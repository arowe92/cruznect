//
//  CruznectRequest.m
//  Cruznect
//
//  Created by Bruce•D•Su on 4/5/14.
//  Copyright (c) 2014 Cruznect. All rights reserved.
//

#import "CruznectRequest.h"

@implementation CruznectRequest

+ (NSDictionary *)executeFetch:(NSString *)query
{
    query = [NSString stringWithFormat:@"%@%@", BASE_URL, query];
    query = [query stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding];
    
    NSLog(@"[%@ %@] sent %@", NSStringFromClass([self class]), NSStringFromSelector(_cmd), query);
    
    NSData *jsonData = [[NSString stringWithContentsOfURL:[NSURL URLWithString:query] encoding:NSUTF8StringEncoding error:nil] dataUsingEncoding:NSUTF8StringEncoding];
    NSError *error = nil;
    NSDictionary *results = jsonData ? [NSJSONSerialization JSONObjectWithData:jsonData options:NSJSONReadingMutableLeaves error:&error] : nil;
    if (error) NSLog(@"[%@ %@] JSON error: %@", NSStringFromClass([self class]), NSStringFromSelector(_cmd), error.localizedDescription);
    
    NSLog(@"[%@ %@] received %@", NSStringFromClass([self class]), NSStringFromSelector(_cmd), results);
    
    return results;
}

//+ (NSArray *)fetchFeaturedProjectsWithUserID:(NSString *)userID
//{
//	NSString *requestString = @"";
//    return [[self executeFetch:requestString] valueForKey:@"response"];
//}

+ (NSArray *)fetchAllProjectsWithUserID:(NSString *)userID
{
    NSString *requestString = @"ver0.2/ver0.2/?action_type=project&action=fetch_all";
    return [[self executeFetch:requestString] valueForKey:@"response"];
}

+ (NSArray *)fetchUserProjectsWithUserID:(NSString *)userID
{
	NSString *requestString =
	[NSString stringWithFormat:@"ver0.2/ver0.2/?action_type=project&action=fetch_user_project&user_id=%@", userID];
    return [[self executeFetch:requestString] valueForKey:@"response"];
}

+ (NSArray *)fetchProjectRequirementsWithProjectID:(NSString *)projectID
{
	NSString *requestString =
	[NSString stringWithFormat:@"ver0.2/ver0.2/?action_type=project&action=fetch_project_requirements&project_id=%@", projectID];
    return [[self executeFetch:requestString] valueForKey:@"response"];
}

+ (void)deleteProject:(NSString *)projectID
{
	NSString *requestString =
	[NSString stringWithFormat:@"ver0.2/ver0.2/?action_type=project&action=delete_project&project_id=%@", projectID];
    [self executeFetch:requestString];
}

+ (NSDictionary *)fetchUserWithUserID:(NSString *)userID
{
	NSString *requestString =
	[NSString stringWithFormat:@"ver0.2/ver0.2/?action_type=user&action=fetch_user&user_id=%@", userID];
    return [[[self executeFetch:requestString] valueForKey:@"response"] objectAtIndex:0];
}

+ (void)postProjectWithPorjectInfo
{
	
}

+ (UIImage *)imageForProject:(NSString *)projectID
{
	return nil;
}

@end
