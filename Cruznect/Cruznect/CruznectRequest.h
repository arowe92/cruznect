//
//  CruznectRequest.h
//  Cruznect
//
//  Created by Bruce•D•Su on 4/5/14.
//  Copyright (c) 2014 Cruznect. All rights reserved.
//

#import <Foundation/Foundation.h>

#define PROJECT_NAME @"name"
#define PROJECT_DESCRIPTION @"description"
#define PROJECT_ID @"id"
#define PROJECT_IMAGE @"imageURL"
#define PROJECT_CREATED_TIME @"created"
#define PROJECT_OWNER @"owner"

#define PROJECT_REQUIRE_TALENT_QUANTITY @"number_of_people"
#define PROJECT_REQUIRE_TALENT_NAME @"name"

#define USER_NAME @"name"
#define USER_EMAIL @"email"

@interface CruznectRequest : NSObject

//+ (NSArray *)fetchFeaturedProjectsWithUserID:(NSString *)userID;

+ (NSArray *)fetchAllProjectsWithUserID:(NSString *)userID;

+ (NSArray *)fetchUserProjectsWithUserID:(NSString *)userID;

+ (NSArray *)fetchProjectRequirementsWithProjectID:(NSString *)projectID;

+ (void)deleteProject:(NSString *)projectID;

+ (NSDictionary *)fetchUserWithUserID:(NSString *)userID;

+ (void)postProjectWithPorjectInfo;

+ (UIImage *)imageForProject:(NSString *)projectID;

@end
