# Questionnaire Maker

Questionnaire Maker is a website where you can build, edit and send questionnaires and collect responses.
[Responses](#responses) can be viewed using graphs (ChartJS) or as raw data in a table format. 
Questionnaire Maker supports 7 [questions](#questions) types split into 3 categories.

### Frameworks Used
* MySQL
* Laravel
    * laravel-cors
* Angular 
    * ChartJS
* SCSS

## Features

### <a name="account-settings">Account and Settings</a>
The account page allows the user to edit account details (email, name, password).
The account page also holds the users settings:
* Enable in app notifications
    * This enables notifications to be displayed within the website 
* Enable email notifications
    * This enables notifications to be emailed to the user
* Notification before questionnaire expiration 
    * This specifics the time period of when to notify the user/you when one of your questionnaires is about to expire
        * None - Never notify you that one of your questionnaires is about to expire
        * Day - Notify you one day before one of your questionnaires is about to expire
        * Week - Notify you one week before one of your questionnaires is about to expire
        * Month - Notify you one month before one of your questionnaires is about to expire
   
For more on notifications check out the [notifications](#notifications) section.    

### <a name="notifications">Notifications</a>    
This application has 3 main notifications in which you will receive.
* New response
    * You will receive a notification each time a new response comes on for one of your questionnaires
* Upcoming expiry
    * Notifies you the specified time ahead of when one of your questionnaires is about to expire
    * For more on expiry times check the [Account and Settings](#account-settings) section.
* Expiry
    * Notifies you that one of your questionnaires has expired.

### Questionnaire
You can create questionnaires. Each questionnaire has a title, category an option description and an optional expiry date after which the questionnaire cannot be answered anymore.
__Once a questionnaire has expired you can no longer collect responses__

Each questionnaire has 2 main options:
* Complete/Incomplete
    * This helps to tell is questionnaires are complete. This means they are ready to be answered by users.
* Public/Private
    * __Public__ questionnaires are displays within the websites public questionnaire page where anyone can answer a questionnaire.
    * __Private__ questionnaires can still be answered but are not displayed to the public.
   

### <a name="questions">Questions</a>
Each question as the choice of being requried (must be submitted) or not required where the user gets to decide.
#### Open
Opens questions allow the user to answer with text in any way they want. 
Both questions are the same programmatically with the only different being in how they are presented ot the user.
##### Single Line Input
Single line input displays a text input with one line to enter text.
##### Paragraph
A paragraph input shows a text area with allows for large amount of text to be displayed.

#### Closed
Closed questions give the user various options in which they can pick. 
##### Multiple Choice
Multiple choice questions give the user a bunch of options from which they can submit one option.
##### Check Boxes
Check box questions give the user a bunch of options from which they can pick one or more options.
##### Drop Down
Works in the same way as the multiple choice but the appearances is as a drop down (select box).

#### Scaled
##### Star
This shows the user a star rating area in which they pick how many stars they wish. 
This question supports between 3 and 10 stars as the max. 
##### Slider
This questions displays a slider in which the user picks a number.
This question supports a range between any numbers with a interval of the creators choosing.

### <a name="responses">Responses</a>
Each question type responses are viewed in different ways with different graphs available.
#### Open
Both open question types are views in a table format. (This is the only option).
#### Closed/ Scaled Star
Closed questions are viewable in 4 different ways:
* Pie chart
* Bar chart
* Horizontal Bar Chart
* Table (Raw Data)
    * There is also a toggle switch with this option to only display options that have responses.
#### Scaled Slider
Slider scaled questions are viewable in 2 different ways:
* Line graph
* Table (Raw Data)
    * There is also a toggle switch with this option to only display options that have responses.

