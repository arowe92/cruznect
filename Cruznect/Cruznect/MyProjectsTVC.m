//
//  MyProjectsTVC.m
//  Cruznect
//
//  Created by Bruce•D•Su on 4/5/14.
//  Copyright (c) 2014 Cruznect. All rights reserved.
//

#import "MyProjectsTVC.h"

@interface MyProjectsTVC () <ProjectTVCDelegate>

@end

@implementation MyProjectsTVC

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
	if ([segue.identifier isEqualToString:@"Project"]) {
		NSIndexPath *indexPath = [self.tableView indexPathForCell:sender];
		NSDictionary *project = [self.projects objectAtIndex:indexPath.section];
		
		ProjectTVC *projectTVC = segue.destinationViewController;
		[projectTVC setProject:project];
		[projectTVC setDelegate:self];
		[projectTVC setCanDeleteProject:YES];
	}
}

- (void)refresh
{
    [self.refreshControl beginRefreshing];
    dispatch_queue_t fetchQ = dispatch_queue_create("Cruznect Fetch", NULL);
    dispatch_async(fetchQ, ^{
        self.projects =
		[CruznectRequest fetchUserProjectsWithUserID:[[NSUserDefaults standardUserDefaults]
														  objectForKey:@"userID"]];
		dispatch_async(dispatch_get_main_queue(), ^{
			[self.tableView reloadData];
			[self.refreshControl endRefreshing];
		});
    });
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
	[self.refreshControl addTarget:self
                            action:@selector(refresh)
                  forControlEvents:UIControlEventValueChanged];
	if ([[NSUserDefaults standardUserDefaults] objectForKey:@"login"]) {
		[self refresh];
	}
}

#pragma mark - ProjectTVC delegate

- (void)userDidDeleteProject:(NSDictionary *)project
{
	[self.navigationController popViewControllerAnimated:YES];
	
	dispatch_queue_t fetchQ = dispatch_queue_create("Cruznect Request", NULL);
    dispatch_async(fetchQ, ^{
		NSString *projectID = [project objectForKey:PROJECT_ID];
        [CruznectRequest deleteProject:projectID];
		dispatch_async(dispatch_get_main_queue(), ^{
			[self refresh];
		});
    });
}

@end
