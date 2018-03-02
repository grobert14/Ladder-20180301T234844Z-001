insert into player 
values ( 'Smith',    'smith@foo.bar', 1, '5035552239', 'smith', 'GuDJvXdUnFFl2' );
insert into player
values ( 'Peters', 'peters@bar.foo', 3,    '5035552230', 'peters', '.eShT.8OuP0Q2' );
insert into player
values ( 'Jones',    'jones@foo.bar', 2, '5035552943', 'jones', 'Dm4zZp2cMP9zo' );
insert into player
values ( 'Green',    'green@foobar.foobar', 4, '5035552320', 'green', 'RToghJ2O0aNwk' );
insert into player
values ( 'Wilson', 'wilson@foo.bar', 5, '5035552939', 'wilson', 'CEmpBIq4dC6h.' );
insert into player
values ( 'Biffer',    'biffer@bar.bar', 6, '5035552948', 'biffer', 'M.ld9Q8dyk2tI' );
insert into player
values ( 'Hansen',    'hansen@bar.foo', 7,    '5035559230', 'hansen', 'GiDPNuNMTkI5Y' );
insert into player
values ( 'Felderfoop',    'foop@foobar.foobar', 8, '5035552321', 'felder', 'eY6/4Yd5d4lAw' );


insert into challenge (challenger, challengee, issued, scheduled)
values ( 'peters', 'jones', now(), 'October 30,2011 19:00 PDT' );


insert into game
values ( 'peters', 'jones', 'July 7,2010 17:00 PDT', 1, 15, 8);
insert into game
values ( 'peters', 'jones', 'July 7,2010 17:00 PDT', 2, 15, 12);
insert into game
values ( 'jones', 'peters', 'July 7,2010 17:00 PDT', 3, 15, 13);
insert into game
values ( 'peters', 'jones', 'July 7,2010 17:00 PDT', 4, 15, 2);

insert into game
values ( 'wilson', 'hansen', 'May 7,2010 17:00 PDT', 1, 15, 8);
insert into game
values ( 'wilson', 'hansen', 'May 7,2010 17:00 PDT', 2, 15, 12);
insert into game
values ( 'wilson', 'hansen', 'May 7,2010 17:00 PDT', 3, 15, 13);

insert into game
values ( 'smith', 'peters', 'April 5, 2010 17:00 PDT', 1, 15, 8);
insert into game
values ( 'peters', 'smith', 'April 5,2010 17:00 PDT', 2, 15, 10);
insert into game
values ( 'smith', 'peters', 'April 5,2010 17:00 PDT', 3, 15, 2);
insert into game
values ( 'peters', 'smith', 'April 5,2010 17:00 PDT', 4, 19, 17);
insert into game
values ( 'smith', 'peters', 'April 5,2010 17:00 PDT', 5, 15, 13);
