# Hot Dog Day - Laravel/VueJS App To Order Hot Dogs

[![Alt text](https://img.youtube.com/vi/HbJqfIZkTwA/0.jpg)](https://www.youtube.com/watch?v=HbJqfIZkTwA)

Does your child's school have Hot Dog Days? Well, then this is the starter project for you.

Enter the days you have hot dog days at your school (for us it is every Tuesday). The app will tell the user when the form is due (for us it's always the Friday before), and will cut off the next hot dog day if it is past the due date.

Why did I build this? Because I was sick of filling out paper forms every month for my child's school. Many parents had asked the school if there was a way they could do it online, but the school does not have the time, nor the expertise. So, I thought maybe I could whip up something cool and fun without too much effort. And here it is.

## Getting Started

Go ahead and fork the repository. This is not a Laravel package, it is a complete project. Feel free to take the whole thing, bits and bobs, or any piece of it you'd like.

Also, I should mention, Hot Dog Days are entered into the hot_dog_days table. The app will present a month's worth of Hot Dog Days to the user, but if you miss the cutoff date for the next Hot Dog Day (the Friday before -- it's hard coded right now in the app), then it will give you one less hot dog day for the month. It will also jump to the next month if there are no hot dog days left in the current month.

### Prerequisites

This is a Laravel 5.7.x project, with VueJS, using Bootstrap 4.x.

### Installing

Fork the project, and do your thing.

## Tests?

No, I didn't do that. This was a silly side project, so I didn't take the time. I know, I should've. But, oh well. Do you want to submit a PR with the test? That'd be cool!

## Built With

* [Laravel](https://laravel.com/) - The PHP framework used
* [VueJS](https://vuejs.org/) - JavaScript framework used
* [Bootstrap CSS](https://getbootstrap.com) - Used to generate RSS Feeds

## Packages Used

* [Laravel Permission](https://github.com/spatie/laravel-permission) - This package is installed, but isn't used currently. I had plans for a nice admin, but decided SequelPro would work just fine for now.
* [Ramsey/uuid](https://github.com/ramsey/uuid) - UUID package for PHP.
* [Bugsnag](https://www.bugsnag.com) - For error tracking.

## Contributing

Please! Submit a PR. But know that I have a full time job as well, so I may, or may not get to your message/PR for a bit.

## Authors

* **JP Davy** - *Initial work* - [JP Davy](https://github.com/jp-davy)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
