# modDiscourseSSO
Single-Sign-On Extra for MODX Revolution that integrates the brilliant Discourse forums.

This extra requires MODX 2.3+ and PHP5.5+

Disclaimer
-

This is a very basic implementation so far. Only user authentication has been built. There's no logout function currently for example.
All suggestions welcome.

Instructions
-

- Download and install Discourse as shown here: https://blog.discourse.org/2014/04/install-discourse-in-under-30-minutes/
- Install this extra via the MODX package manager
- Set your discourse host name, your secret code, and your scheme (http or https) for modDiscourseSSO in the MODX system settings.
- Create a resource called "Discourse" (or anything you like) and add the snippet `[[!discourse]]` to either the resource content field or directly to the template.
- Fill out the SSO settings within Discourse as shown here: https://meta.discourse.org/t/official-single-sign-on-for-discourse-sso/13045
  - The sso_secret should be the same as the one you added to MODX
  - The sso_url should be the full URL where your `[[!discourse]]` snippet resides. 
- The next time you see load Discourse (while logged into MODX) you'll see your MODX accout details showing up in Discourse.
