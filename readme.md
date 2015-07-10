# Kagi (Authentification / Authorization) : Laravel 5.1.x Beta Development


## Functionality


### Permissions
Supplements the main Rakko app's locale functionality.
Ability to control Locales through the database.


### Roles
Settings allow you to set key/values to the database or to a .json file


### Users
Settings allow you to set key/values to the database or to a .json file


## Routes

* /admin/permissions
* /admin/roles
* /admin/users


* auth/login
* social/login


## Install

```
GITHUB_CLIENT_ID=
GITHUB_CLIENT_SECRET=
GITHUB_REDIRECT=http://www.site.com/social/login

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT=http://www.site.com/social/login
```


## Packages


* https://github.com/illuminate3/kotoba
```
"illuminate3/kotoba": "dev-master",
Illuminate3\Kotoba\KotobaServiceProvider::class,
```


* https://github.com/vinkla/translator
```
'Vinkla\Translator\TranslatorServiceProvider'
vendor:publish --provider="Vinkla\Translator\TranslatorServiceProvider"
```


* https://github.com/caffeinated/shinobi
```
composer require caffeinated/shinobi=~2.0
Caffeinated\Shinobi\ShinobiServiceProvider::class
```

```
vendor:publish --provider="Caffeinated\Shinobi\ShinobiServiceProvider"
```

* https://github.com/GrahamCampbell/Laravel-Throttle
```
"graham-campbell/throttle": "~4.1"
'GrahamCampbell\Throttle\ThrottleServiceProvider'
'Throttle' => 'GrahamCampbell\Throttle\Facades\Throttle'
```

```
vendor:publish --provider="GrahamCampbell\Throttle\ThrottleServiceProvider"
```

* https://github.com/laravel/socialite
```
composer require laravel/socialite
Laravel\Socialite\SocialiteServiceProvider::class,
'Socialite' => Laravel\Socialite\Facades\Socialite::class,
```


## Thanks
A very special thanks and arigatou! to Kai over at ( https://github.com/caffeinated )
Thanks for your patience and help!

I also should mention the 2 starter kits for L4. Without them I would never have gotten this far with Laravel.

Also, to Laravel. Besides being a "y'all" know a killer framework from Arkansas,
but also for making me have to drive on the opposite side of the road again ... or if you rather say,
the correct side of the road.


## Partial Code or Ideas


