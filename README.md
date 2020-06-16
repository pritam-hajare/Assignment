# Assignment
 

Problem Statement:

As a user, I want a robot to clean my 2 apartments. 

The first apartment has a 70 m2 hard floor. 

The second apartment has a 60 m2 carpeted floor. 

The robot should charge its battery itself once it runs out of energy. 

I want to run a command $ robot.php clean --floor=carpet --area=70 and I want to see the state output while it's cleaning or charging the battery. 

The --floor parameter should accept either hard or carpet to determine how the robot should behave based on the following assumptions. 

Output should be a periodic status on the current state of the different entities.

Assumptions:

● The robot has a battery big enough to clean for 60 seconds in one charge. 

● The robot can clean 1 m2 of hard floor in 1 second. 

● The robot can clean 1 m2 of carpet in 2 seconds. 

● The battery charge from 0 to 100% takes 30 seconds.

● Default action would be "clean"


Solution :

$php robot.php --action=clean --floor=hard --area=70

Expected Output -

Robot Started Floor Cleaning

43%[======================>                            ]Cleaning

Robot Started Battery Charging

100%[==================================================>]Charging

 Robot Resumed Floor Cleaning

86%[===========================================>       ]Cleaning

Robot Started Battery Charging

100%[==================================================>]Charging

 Robot Resumed Floor Cleaning

100%[==================================================>]Cleaning

Robot Finished Floor Cleaning

------------------------------------------------------------------------------------------------------------------------------------






