INSERT INTO Account VALUES (
	DEFAULT, --1,
	'testi',
	'$2y$10$Coj81cumngk/errkj8gGD.LQHrluWrwbpGR6vMa6wPfVxCJvQPCS.', -- 'testi'
	true
);

INSERT INTO Priority VALUES (
	DEFAULT, --1,
	1,
	100,
	'megatärkeä'
);

INSERT INTO Priority VALUES (
	DEFAULT, --2,
	1,
	-100,
	'roskis'
);

INSERT INTO Priority VALUES (
	DEFAULT, --3,
	1,
	0,
	'aika perus'
);

INSERT INTO Category VALUES (
	DEFAULT, --1,
	1,
	'Ostoslista'
);

INSERT INTO Category VALUES (
	DEFAULT, --2,
	1,
	'Katsottavat'
);

INSERT INTO Task VALUES (
	DEFAULT, --1,
	1,
	1,
	'Täysmaito'
);

INSERT INTO Task VALUES (
	DEFAULT, --2,
	1,
	2,
	'Riippumatto'
);

INSERT INTO Task VALUES (
	DEFAULT, --3,
	1,
	3,
	'Vyön rei''itin'
);

INSERT INTO TaskCategory VALUES ( 1, 1 );
INSERT INTO TaskCategory VALUES ( 2, 1 );
INSERT INTO TaskCategory VALUES ( 3, 1 );

INSERT INTO Task VALUES (
	DEFAULT, --4,
	1,
	2,
	'The Village'
);

INSERT INTO Task VALUES (
	DEFAULT, --5,
	1,
	1,
	'Star Wars Holiday Special'
);

INSERT INTO TaskCategory VALUES ( 4, 2 );
INSERT INTO TaskCategory VALUES ( 5, 2 );

INSERT INTO Task VALUES (
	DEFAULT, --6,
	1,
	1,
	'Lapioi lumet'
);
