//
//  ProjectsTVC.h
//  Cruznect
//
//  Created by Bruce•D•Su on 4/5/14.
//  Copyright (c) 2014 Cruznect. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "CruznectRequest.h"
#import "ProjectTVC.h"

#define kImageViewTag 11
#define kTitleTextLabelTag 22
#define kDetailTextViewTag 33
#define kTalentStringTag 44

@interface ProjectsTVC : UITableViewController

@property (strong, nonatomic) NSArray *projects;

@end
