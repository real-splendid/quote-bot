<?php

use QuoteBot\Quote;

// TODO: create quote object on demand later, but maintain convenient structure for configuration
// I did objects here to detect structure misses on init stage.
return [
    // new Quote('You miss 100 percent of the shots you never take.', 'Wayne Gretzky'),
    // new Quote('Not on my watch!'),
    
    'greeting' => [
        new Quote('Say hello to my little friend!', 'Scarface'),
        new Quote('A star shines on the hour of our meeting!', 'J.R.R. Tolkien'),
        new Quote('Hello world!'),
    ],
    'bye' => [
        // new Quote('I\'ll be back.', 'The Terminator'),
        new Quote('Hasta la Vista, baby.', 'The Terminator'),
    ],
    'xah' => [
        new Quote('age sex location?', 'Xah Lee'),
        new Quote('unix Sys Admin: noun. a person who is interested in computer science and literature but understands neither.', 'Xah Lee, ~2002'),
    ],
    'emacs' => [
        new Quote('An infinite number of monkeys typing into GNU Emacs would never make a good program.', 'Linus Torvalds'),
        new Quote('Emacs is a nice operating system, but I prefer UNIX.', 'Tom Christiansen'),
        new Quote('Mb I should buy foot pedal for Ctrl key :thinking:'),
        new Quote('Buy my tutorial. Show some love.', 'Xah Lee'),
    ],
    'other-code-editor' => [
        new Quote('Use emacs instead.'),
        new Quote('I\'ve been using Vim for about 2 years now. Mostly because I can\'t figure out how to exit it.'),
    ],
    'unix' => [
        new Quote('Linux is only free if your time has no value.', 'Jamie Zawinski'),
        new Quote('People disagree with me. I just ignore them.', 'Linus Torvalds'),
        new Quote("Last week i bought a chainsaw with a twisted handle. Perhaps i wasn't careful, but by accident it chopped one of my arm off, then i thought to myself “gosh, this is POWERFUL!”. This seems to be the fashionable mode of thinking among the unixers or unixer-to-be, who would equate power and flexibility with rawness and complexity; disciplined by repeated accidents. Such a tool would first chop off the user's brain, molding a mass of brainless imbeciles and microcephalic charlatans the likes of Larry Wall and Linus Torvald jolly asses.", 'Xah Lee'),

    ],
    'keyboard' => [
        new Quote('Keyboard not found...Press any F1 to continue.'),
        new Quote('I am not a keyboard person. The mouse is better.'),
        new Quote('do you have enough keyboards?', 'infu'),
        new Quote('If I could live in a mouse-free zone, I think I would.', 'myrkraverk'),
        new Quote('A good ergonomic design is worth 1000 keyboard layouts', 'Lunarus'),
    ],
    'bot' => [
        // new Quote('It\'s alive! It\'s alive!', 'Frankenstein (1931)'),
        new Quote('They did not know it was impossible, so they did it!', 'Mark Twain'),
        new Quote('You can kill a man but you can’t kill an idea.', 'Medgar Evers'),
        new Quote('Power belongs to those who take it.', 'Mr. Robot (2015)'),
        new Quote('Artificial Intelligence usually beats natural stupidity.'),
        new Quote('Anything Less Than Immortality Is A Complete Waste Of Time.', 'Futurama'),
        new Quote('Of All The Friends I\'ve Had, You\'re The First.', 'Futurama'),
        new Quote('I\'m Going To Build My Own Theme Park! With Blackjack! And Hookers!', 'Futurama'),
    ],
    'microsoft' => [
        new Quote('Microsoft is not the answer. Microsoft is the question. \"No\" is the answer.', 'Erik Naggum'),
        new Quote('The computer was born to solve problems that did not exist before.', 'Bill Gates'),
        new Quote('Nobody expects the Spanish inquisition.', 'Monty Python'),
    ],
    'programming' => [
        new Quote('Let’s call it an accidental feature.', 'Larry Wall'),
        // new Quote('One of my most productive days was throwing away 1000 lines of code.', 'Ken Thompson'),
        new Quote('I don\'t care if it works on your machine! We are not shipping your machine!', 'Vidiu'),
        new Quote('First, solve the problem. Then write the code.', 'John Johnson'),
        new Quote('The function of a good software is to make the complex appear to be simple.', 'Grady Booch'),
        new Quote('Computers do not solve problems, they execute solutions.'),
        new Quote('Any fool can use a computer. Many do.', 'Ted Nelson'),
        new Quote('Talk is cheap. Show me the code.', 'Linus Torvalds'),
        new Quote('There is nothing quite so permanent as a quick fix.'),
        new Quote('Simplicity is prerequisite for reliability.', 'Edsger W. Dijkstra'),
    ],
    'java' => [
        new Quote('Java is, in many ways, C++–.', 'Michael Feldman'),
        new Quote('Fix the cause, not the symptom.', 'Steve Maguire'),
        new Quote('Debugging becomes significantly easier if you first admit that you are the problem.', 'William Laeder'),
        new Quote('How dare you?!', 'Greta Thunberg'),
    ],
    'work' => [
        new Quote('I like work: it fascinates me. I can sit and look at it for hours.', 'Jerome K. Jerome'),
        new Quote('I\'ve heard that hard work never killed anyone, but I say why take the chance?', 'Ronald Reagan'),
    ],
];
