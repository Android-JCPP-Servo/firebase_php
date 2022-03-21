# firebase_php
 
This is my project for connecting to Firebase via PHP. The full tutorial for this project can be found here: https://www.youtube.com/playlist?list=PLRheCL1cXHrvJRiQVf1FXLt6To7cIaHqf.

I would highly recommend it to anyone wishing to learn the processes of connecting to Firebase via PHP.

As an important note, some of the Firebase SDK information is undefined or deprecated:
- In the documentation, under Authentication, in the "Verify a Firebase ID Token" section, the original error-catching method uses FailedToVerifyToken. This method is undefined, according to Intelephense 1.3 Error Code 1009.
- The more current method to use can be found in my code: 'authentication.php', line 13.

Thank you for your interest!
