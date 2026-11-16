# API Routes

### sanctum/csrf-cookie
- Method: GET|HEAD
- Action: Laravel\Sanctum\Http\Controllers\CsrfCookieController@show

### _ignition/health-check
- Method: GET|HEAD
- Action: Spatie\LaravelIgnition\Http\Controllers\HealthCheckController

### _ignition/execute-solution
- Method: POST
- Action: Spatie\LaravelIgnition\Http\Controllers\ExecuteSolutionController

### _ignition/update-config
- Method: POST
- Action: Spatie\LaravelIgnition\Http\Controllers\UpdateConfigController

### api/user
- Method: GET|HEAD
- Action: Closure

### /
- Method: GET|HEAD
- Action: App\Http\Controllers\HomeController@index

### ecoknights/home
- Method: GET|HEAD
- Action: App\Http\Controllers\HomeController@index

### ecoknights/sign-up
- Method: GET|HEAD
- Action: App\Http\Controllers\SignupController@getSignup

### ecoknights/sign-up
- Method: POST
- Action: App\Http\Controllers\SignupController@postSignup

### ecoknights/log-in
- Method: GET|HEAD
- Action: App\Http\Controllers\LoginController@getLogin

### ecoknights/log-in
- Method: POST
- Action: App\Http\Controllers\LoginController@postLogin

### ecoknights/log-out
- Method: POST
- Action: App\Http\Controllers\LoginController@postLogout

### ecoknights/profile/update
- Method: GET|HEAD
- Action: App\Http\Controllers\ProfileController@getUpdateProfile

### ecoknights/profile/update
- Method: PUT
- Action: App\Http\Controllers\ProfileController@putUpdateProfile

### ecoknights/volunteer/create
- Method: GET|HEAD
- Action: App\Http\Controllers\VolunteerController@getCreateVolunteer

### ecoknights/volunteer/create/{eventId}
- Method: POST
- Action: App\Http\Controllers\VolunteerController@postCreateVolunteer
- Parameters: eventId

### ecoknights/feedback/create
- Method: GET|HEAD
- Action: App\Http\Controllers\FeedbackController@getCreateFeedback

### ecoknights/feedback/create
- Method: POST
- Action: App\Http\Controllers\FeedbackController@postCreateFeedback

### ecoknights/profile/read
- Method: GET|HEAD
- Action: App\Http\Controllers\ProfileController@getReadProfile

### ecoknights/profile/create
- Method: GET|HEAD
- Action: App\Http\Controllers\ProfileController@getCreateProfile

### ecoknights/profile/create
- Method: POST
- Action: App\Http\Controllers\ProfileController@postCreateProfile

### ecoknights/profile/update/{id}
- Method: GET|HEAD
- Action: App\Http\Controllers\ProfileController@getUpdateProfile
- Parameters: id

### ecoknights/profile/update/{id}
- Method: PUT
- Action: App\Http\Controllers\ProfileController@putUpdateProfile
- Parameters: id

### ecoknights/profile/delete/{id}
- Method: GET|HEAD
- Action: App\Http\Controllers\ProfileController@getDeleteProfile
- Parameters: id

### ecoknights/profile/delete/{id}
- Method: DELETE
- Action: App\Http\Controllers\ProfileController@deleteProfile
- Parameters: id

### ecoknights/volunteer/read
- Method: GET|HEAD
- Action: App\Http\Controllers\VolunteerController@getReadVolunteer

### ecoknights/volunteer/update/{participationId}
- Method: GET|HEAD
- Action: App\Http\Controllers\VolunteerController@getUpdateVolunteer
- Parameters: participationId

### ecoknights/volunteer/update/{participationId}
- Method: PUT
- Action: App\Http\Controllers\VolunteerController@putUpdateVolunteer
- Parameters: participationId

### ecoknights/volunteer/delete/{participationId}
- Method: GET|HEAD
- Action: App\Http\Controllers\VolunteerController@getDeleteVolunteer
- Parameters: participationId

### ecoknights/volunteer/delete/{participationId}
- Method: DELETE
- Action: App\Http\Controllers\VolunteerController@deleteVolunteer
- Parameters: participationId

### ecoknights/feedback/read
- Method: GET|HEAD
- Action: App\Http\Controllers\FeedbackController@getReadFeedback

### ecoknights/feedback/update/{feedbackId}
- Method: GET|HEAD
- Action: App\Http\Controllers\FeedbackController@getUpdateFeedback
- Parameters: feedbackId

### ecoknights/feedback/update/{feedbackId}
- Method: PUT
- Action: App\Http\Controllers\FeedbackController@putUpdateFeedback
- Parameters: feedbackId

### ecoknights/feedback/delete/{feedbackId}
- Method: GET|HEAD
- Action: App\Http\Controllers\FeedbackController@getDeleteFeedback
- Parameters: feedbackId

### ecoknights/feedback/delete/{feedbackId}
- Method: DELETE
- Action: App\Http\Controllers\FeedbackController@deleteFeedback
- Parameters: feedbackId

