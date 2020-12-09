# camagru
42 project, Instagram-like website


FROM THE CAMAGRU PDF GUIDE






GENERAL INSTRUCTIONS

• Your web application must produce no errors, no warning or log line in any console,
server side and client side. Nonetheless, due to the lack of HTTPS, any error related
to getUserMedia() are tolerated.

• You must use ony PHP language to create your server-side application, with just
the standard library.

• Client-side, your pages must use HTML, CSS and JavaScript.

• Every framework, micro-framework or library that you don’t create are totally
forbidden, except for CSS frameworks that doesn’t need forbidden JavaScript.

• You must use the PDO abstraction driver to communicate with your database,
that must be queryable with SQL. The error mode of this driver must be set to
PDO::ERRMODE_EXCEPTION

• Your application must be free of any security leak. You must handle at least cases
mentioned in the mandatory part. Nonetheless, you are encouraged to go deeper
into your application’s safety, think about your data’s privacy !

• You are free to use any webserver you want, like Apache, Nginx or even the built-in
webserver1

• Your web application should be at least be compatible with Firefox (>= 41) and
Chrome (>= 46).


COMMON FEATURES

You will develop a web application. Even if this is not required, try to structure your
application (as a MVC application, for instance).
Your website should have a decent page layout (meaning at least a header, a main section
and a footer), be able to display correctly on mobile devices and have an adapted layout
on small resolutions.
All your forms should have correct validations and the whole site should be secured.
This point is MANDATORY and shall be verified when your application would be evaluated. To have an idea, here are some stuff that is NOT considered as SECURE:

• Store plain or unencrypted passwords in the database.

• Offer the ability to inject HTML or “user” JavaScript in badly protected variables.

• Offer the ability to upload unwanted content on the server.

• Offer the possibility of altering an SQL query.

• Use an extern form to manipulate so-called private data


USER FEATURES

The application should allow a user to sign up by asking at least a valid email
address, an username and a password with at least a minimum level of complexity.

• At the end of the registration process, an user should confirm his account via a
unique link sent at the email address fullfiled in the registration form.

• The user should then be able to connect to your application, using his username
and his password. He also should be able to tell the application to send a password
reinitialisation mail, if he forget his password.

• The user should be able to disconnect in one click at any time on any page.

• Once connected, an user should modify his username, mail address or password.


GALLERY FEATURES

This part is to be public and must display all the images edited by all the users,
ordered by date of creation. It should also allow (only) a connected user to like
them and/or comment them.

• When an image receives a new comment, the author of the image should be notified
by email. This preference must be set as true by default but can be deactivated in
user’s preferences.

• The list of images must be paginated, with at least 5 elements per page.


EDITING FEATURES

This part should be accessible only to users that are authentified/connected and gently reject all other users that attempt to access it without being successfully logged in.
This page should contain 2 sections:

• A main section containing the preview of the user’s webcam, the list of superposable
images and a button allowing to capture a picture.

• A side section displaying thumbnails of all previous pictures taken.
Your page layout should normally look like in Figure V.1.

• Superposable images must be selectable and the button allowing to take the picture should be inactive (not clickable) as long as no superposable image has been
selected.

• The creation of the final image (so among others the superposing of the two images)
must be done on the server side, in PHP.

• Because not everyone has a webcam, you should allow the upload of a user image
instead of capturing one with the webcam.

• The user should be able to delete his edited images, but only his, not other users’
creations.
