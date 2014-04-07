//
//  LoginTVC.m
//  Cruznect
//
//  Created by Bruce•D•Su on 4/5/14.
//  Copyright (c) 2014 Cruznect. All rights reserved.
//

#import "LoginTVC.h"

@interface LoginTVC () <UIAlertViewDelegate>
@property (weak, nonatomic) IBOutlet UITextField *emailTextField;
@property (weak, nonatomic) IBOutlet UITextField *passwordTextField;
@property (strong, nonatomic) UIAlertView *loginErrorAlertView;
@property (strong, nonatomic) NSString *userID;
@end

@implementation LoginTVC

- (void)setupBackground
{
	self.tableView.backgroundColor =
	[UIColor colorWithPatternImage:[UIImage imageNamed:@"bridge-tableview"]];
	[self.navigationController.navigationBar setBackgroundImage:[UIImage imageNamed:@"bridge-navbar"] forBarMetrics:UIBarMetricsDefault];
}

- (void)viewDidLoad
{
	[super viewDidLoad];
	
//	[self setupBackground];
}

- (void)viewDidAppear:(BOOL)animated
{
	[super viewDidAppear:animated];
	
	[self.emailTextField becomeFirstResponder];
}

NSString * const kLoginScriptURLString = @"ver0.2/ver0.2/?action_type=user&action=login";

- (BOOL)executeRequestWithRequestBody:(NSString *)requestBody
{
	NSString *urlString = [NSString stringWithFormat:@"%@%@", BASE_URL, kLoginScriptURLString];
    NSURL *reqeustURL = [NSURL URLWithString:urlString];
    const char *requestBodyStr = [requestBody UTF8String];
    NSData *requestData = [NSData dataWithBytes:requestBodyStr length:strlen(requestBodyStr)];
    
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:reqeustURL];
    [request setHTTPMethod:@"POST"];
    [request setHTTPBody:requestData];
    
	NSData *data = [NSURLConnection sendSynchronousRequest:request returningResponse:NULL error:NULL];
    
    NSDictionary *results = data ? [NSJSONSerialization JSONObjectWithData:data options:NSJSONReadingMutableContainers|NSJSONReadingMutableLeaves error:nil] : nil;
	
	NSLog(@"%@", results);
	
    if ([[results objectForKey:@"status-code"] isEqual:[NSNumber numberWithInt:200]]) {
		NSDictionary *response = [results valueForKey:@"response"];
		self.userID = [response objectForKey:@"id"];
        return YES;
    } else {
        return NO;
    }
}

NSString * const kLoginErrorAlertTitle = @"Login Error";
NSString * const kLoginErrorAlertMessage = @"Check you email and password";

- (UIAlertView *)loginErrorAlertView
{
    if (!_loginErrorAlertView) {
        _loginErrorAlertView = [[UIAlertView alloc] initWithTitle:kLoginErrorAlertTitle
														  message:kLoginErrorAlertMessage
														 delegate:self
												cancelButtonTitle:@"Done"
												otherButtonTitles:nil];
    }
    return _loginErrorAlertView;
}

- (void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex
{
	if (buttonIndex == 0) {
		[self.emailTextField resignFirstResponder];
		[self.passwordTextField resignFirstResponder];
		[self.emailTextField becomeFirstResponder];
	}
}

- (IBAction)finishInputingEmail:(id)sender
{
	[sender resignFirstResponder];
	[self.passwordTextField becomeFirstResponder];
}

- (IBAction)finishInputingPasswordPressed:(id)sender
{
	[self.passwordTextField resignFirstResponder];
	[self login];
}

- (IBAction)loginButtonPressed:(id)sender
{
	[self login];
}

- (void)login
{
	NSString *emailString = self.emailTextField.text;
	NSString *passwordString = self.passwordTextField.text;
	
	NSString *requestBody = [NSString stringWithFormat:@"email=%@&password=%@", emailString, passwordString];
    
	UIBarButtonItem *loginBarButtonItem = self.navigationItem.rightBarButtonItem;
	UIActivityIndicatorView *spinner = [[UIActivityIndicatorView alloc] initWithActivityIndicatorStyle:UIActivityIndicatorViewStyleWhite];
    [spinner startAnimating];
	
    self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc] initWithCustomView:spinner];
    
    dispatch_queue_t verifyQ = dispatch_queue_create("Cruznect Verify", NULL);
    dispatch_async(verifyQ, ^{
		BOOL login =
		[self executeRequestWithRequestBody:requestBody];
		
        dispatch_async(dispatch_get_main_queue(), ^{
            if (login) {
                self.navigationItem.rightBarButtonItem =
				[[UIBarButtonItem alloc] initWithTitle:@"Succeed!"
												 style:UIBarButtonItemStyleBordered
												target:nil
												action:nil];
				[self.delegate loginSucceedWithEmail:emailString
											password:passwordString
										   andUserID:self.userID];
            } else {
				self.navigationItem.rightBarButtonItem = loginBarButtonItem;
                [self.loginErrorAlertView show];
            }
        });
    });
}

@end