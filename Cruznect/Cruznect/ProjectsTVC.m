//
//  ProjectsTVC.m
//  Cruznect
//
//  Created by Bruce•D•Su on 4/5/14.
//  Copyright (c) 2014 Cruznect. All rights reserved.
//

#import "ProjectsTVC.h"

@interface ProjectsTVC ()

@end

@implementation ProjectsTVC

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
	if ([segue.identifier isEqualToString:@"Project"]) {
		NSIndexPath *indexPath = [self.tableView indexPathForCell:sender];
		NSDictionary *project = [self.projects objectAtIndex:indexPath.section];
		
		ProjectTVC *projectTVC = segue.destinationViewController;
		[projectTVC setProject:project];
		[projectTVC setCanDeleteProject:NO];
	}
}

#pragma mark - Table view data source

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return [self.projects count];
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
	return 1;
}


- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"Project"
															forIndexPath:indexPath];
    
	NSDictionary *project = [self.projects objectAtIndex:indexPath.section];
	
	
	
	UILabel *titleLabel = (UILabel *)[cell viewWithTag:kTitleTextLabelTag];
	titleLabel.text = [project objectForKey:PROJECT_NAME];
	
	
	dispatch_queue_t fetchQ = dispatch_queue_create("Cruznect Fetch", NULL);
    dispatch_async(fetchQ, ^{
        NSArray *talents = [CruznectRequest fetchProjectRequirementsWithProjectID:[project objectForKey:PROJECT_ID]];
		UIImage *image = [CruznectRequest imageForProject:[project objectForKey:PROJECT_IMAGE]];
		dispatch_async(dispatch_get_main_queue(), ^{
			NSString *talentString = @"";
			BOOL needComma = NO;
			for (NSDictionary *talent in talents) {
				if (needComma == NO) {
					talentString =
					[NSString stringWithFormat:@"%@", [talent objectForKey:PROJECT_REQUIRE_TALENT_NAME]];
					needComma = YES;
				} else {
					talentString =
					[NSString stringWithFormat:@"%@, %@", talentString, [talent objectForKey:PROJECT_REQUIRE_TALENT_NAME]];
				}
			}
			UILabel *talentLabel = (UILabel *)[cell viewWithTag:kTalentStringTag];
			talentLabel.text = talentString;
			
			UIImageView *imageView = (UIImageView *)[cell viewWithTag:kImageViewTag];
			imageView.image = image;
		});
    });
	
	UITextView *detailTextView = (UITextView *)[cell viewWithTag:kDetailTextViewTag];
	detailTextView.text = [project objectForKey:PROJECT_DESCRIPTION];
    
    return cell;
}

#pragma mark - Table view delegate

- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
	return 132.0;
}

@end