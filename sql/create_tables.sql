CREATE TABLE Account (
	id SERIAL PRIMARY KEY,
	nick VARCHAR(64) UNIQUE NOT NULL,
	password VARCHAR(255),
	admin BOOLEAN
);

CREATE TABLE Priority (
	id SERIAL PRIMARY KEY,
	priority INTEGER, -- isompi tärkeämpi, "baseline" 0
	name VARCHAR(64)
);

CREATE TABLE Task (
	id SERIAL PRIMARY KEY,
	account_id INTEGER REFERENCES Account(id),
	priority_id INTEGER REFERENCES Priority(id),
	task VARCHAR(255)
);

CREATE TABLE Category (
	id SERIAL PRIMARY KEY,
	account_id INTEGER REFERENCES Account(id),
	name VARCHAR(64)
);

CREATE TABLE TaskCategory (
	task_id INTEGER REFERENCES Task(id),
	category_id INTEGER REFERENCES Category(id)
);
