# modDiscourseSSO
Single-Sign-On Extra for MODX Revolution that integrates the brilliant Discourse forums.

This extra requires MODX 2.3+ and PHP5.5+


Instructions
-

- Download and install Discourse as shown here: https://blog.discourse.org/2014/04/install-discourse-in-under-30-minutes/
- Install this extra via the MODX package manager
- Set your discourse host name, your secret code, and your scheme (http or https) for modDiscourseSSO in the MODX system settings.
- Create a resource called "Discourse" (or anything you like) and add the snippet ```[[!discourse? &loginPage=`54`]]``` to either the resource content field or directly to the template.
    - If you haven't already, create a resource to contain your MODX login form. The resource id of this page should be entered into &loginPage parameter of the snippet.
    - Also a resource that contains a logout snippet. (For example you can use the one from the Login Extra.)
- Fill out the SSO settings within Discourse as shown here: https://meta.discourse.org/t/official-single-sign-on-for-discourse-sso/13045
    - The sso_secret should be the same as the one you added to MODX
    - The sso_url should be the full URL where your ```[[!discourse? &loginPage=`54`]]``` snippet resides. 
    - Also set the "logout redirect" setting (under Users) should contain the full URL of your MODX logout snippet.
- The next time you load Discourse (while logged into MODX) you'll see your MODX account details showing up in Discourse.


Parameters
-
- ```&loginPage``` - This is the resource id of your MODX login page. Unauthorized users will be redirected to this page. If the parameter is not included with the snippet the value of the login_page system setting will be used instead. This param will also accept a URL in case the page you want to redirect to is outside of MODX.
 