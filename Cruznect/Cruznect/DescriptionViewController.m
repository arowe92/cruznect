//
//  DescriptionViewController.m
//  Cruznect
//
//  Created by Bruce•D•Su on 4/6/14.
//  Copyright (c) 2014 Cruznect. All rights reserved.
//

#import "DescriptionViewController.h"
#import "CruznectRequest.h"

@interface DescriptionViewController ()
@property (weak, nonatomic) IBOutlet UITextView *textView;
@end

@implementation DescriptionViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
	
	self.title = [self.project objectForKey:PROJECT_NAME];
	self.textView.text = [self.project objectForKey:PROJECT_DESCRIPTION];
}

@end
