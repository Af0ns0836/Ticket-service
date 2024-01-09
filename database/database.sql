PRAGMA foreign_keys = ON;
BEGIN TRANSACTION;
.mode columns
.headers on

DROP TABLE IF EXISTS users;

CREATE TABLE users (
  userid INTEGER PRIMARY KEY,        -- user id
  username VARCHAR unique,           -- unique username
  password VARCHAR(255),             -- password stored in sha-1
  name VARCHAR,                      -- real name
  email VARCHAR,                     -- email
  type VARCHAR                       -- type of user
);

DROP TABLE IF EXISTS agents;

CREATE TABLE agents (
  id INTEGER PRIMARY KEY,
  username VARCHAR,
  department INTEGER,
  FOREIGN KEY (department) REFERENCES departments(id)
);


CREATE TRIGGER insert_agent
AFTER INSERT ON users
FOR EACH ROW
WHEN NEW.type = 'agent'
BEGIN
    INSERT INTO agents (username)
    VALUES (NEW.username);
END;

CREATE TRIGGER insert_agent_update_user
AFTER UPDATE ON users
FOR EACH ROW
WHEN NEW.type = 'agent'
BEGIN
    INSERT INTO agents (username)
    VALUES (NEW.username);
END;


DROP TABLE IF EXISTS ticket;

CREATE TABLE ticket (
  id INTEGER PRIMARY KEY,
  title VARCHAR,
  published INTEGER,
  user VARCHAR,
  subject VARCHAR,
  fulltext VARCHAR,
  priority VARCHAR,
  status VARCHAR,
  department VARCHAR,
  agent VARCHAR,
  FOREIGN KEY (user) REFERENCES users(username)
    ON UPDATE CASCADE
);

DROP TABLE IF EXISTS hashtag;

CREATE TABLE hashtag (
  id INTEGER PRIMARY KEY,
  text VARCHAR
);

DROP TABLE IF EXISTS ticket_hashtag;

CREATE TABLE ticket_hashtag (
  ticket_id INTEGER,
  hashtag_id INTEGER,
  PRIMARY KEY (ticket_id, hashtag_id),
  FOREIGN KEY (ticket_id) REFERENCES ticket(id),
  FOREIGN KEY (hashtag_id) REFERENCES hashtag(id)
);

DROP TABLE IF EXISTS comments;

CREATE TABLE comments (
  id INTEGER PRIMARY KEY,            -- comment id
  ticket_id INTEGER,                 -- news item this comment is about
  username VARCHAR,                  -- user that wrote the comment
  published INTEGER,                 -- date when comment was published in epoch format
  text VARCHAR,                      -- comment text
  FOREIGN KEY (ticket_id) REFERENCES ticket(id),   -- reference the 'id' column in the 'ticket' table
  FOREIGN KEY (username) REFERENCES users(username) -- reference the 'username' column in the 'users' table
    ON UPDATE CASCADE 
);

DROP TABLE IF EXISTS departments;

CREATE TABLE departments (
  id INTEGER PRIMARY KEY,           -- id
  name VARCHAR UNIQUE                  -- name of the department
);

DROP TABLE IF EXISTS faq;

CREATE TABLE faq (
  faq_id INTEGER PRIMARY KEY,
  question VARCHAR,                        --  faq question
  answer VARCHAR  -- faq answer
);
-- Insert departments
INSERT INTO departments (id,name) VALUES
(1,'IT'),
(2,'Product'),
(3, 'Sales');

INSERT INTO users (userid, username, password, name, email, type)
VALUES (1, 'user', '$2y$10$j4m7LSiGo.AdmSttrv45a.H13mKWAXoriM97kcDyBBCgNTt4bU.VS', 'John Doe', 'john@example.com', 'user'),
(2, 'agent1', '$2y$10$j4m7LSiGo.AdmSttrv45a.H13mKWAXoriM97kcDyBBCgNTt4bU.VS', 'jane smith', 'jane@example.com', 'agent'),
(3, 'agent2', '$2y$10$j4m7LSiGo.AdmSttrv45a.H13mKWAXoriM97kcDyBBCgNTt4bU.VS', 'Jonh Smith', 'jonh@example.com', 'agent'),
(4, 'admin', '$2y$10$j4m7LSiGo.AdmSttrv45a.H13mKWAXoriM97kcDyBBCgNTt4bU.VS', 'jennifer davis', 'jen@example.com', 'admin');

UPDATE agents set department = 2;

INSERT INTO ticket (id, title, published, user, subject, fulltext, priority, status, department, agent)
VALUES (1, 'Support Request', '2023-01-21 19:00:15', 'user', 'Technical Issue', 'I am experiencing connectivity problems', 'High', 'Open', 'IT', 'agent1');

INSERT INTO ticket (id, title, published, user, subject, fulltext, priority, status, department, agent)
VALUES (2, 'Product Support', '2023-05-01 08:26:15', 'agent1', 'Feature Request', 'I would like to suggest a new feature', 'Low', 'Open', 'Product', 'agent2');

INSERT INTO ticket (id, title, published, user, subject, fulltext, priority, status, department, agent)
VALUES (3, 'Account Assistance', '2022-24-21 10:29:00', 'user', 'Account Access Issue', 'I am unable to log in to my account', 'High', 'Open', 'Customer Support', 'agent2');

INSERT INTO ticket (id, title, published, user, subject, fulltext, priority, status, department, agent)
VALUES (4, 'Technical Support', '2023-11-21 20:19:15', 'agent2', 'Software Installation Issue', 'I am having trouble installing the latest software update', 'High', 'Open', 'IT', 'agent1');

INSERT INTO ticket (id, title, published, user, subject, fulltext, priority, status, department, agent)
VALUES (5, 'Product Inquiry', '2023-03-15 21:29:15', 'admin', 'Product Availability', 'I would like to know if the product is currently in stock', 'Medium', 'Open', 'Sales', 'agent2');


INSERT INTO hashtag (id, text)
VALUES (1, '#urgent'),(2, '#bug');

INSERT INTO ticket_hashtag (ticket_id, hashtag_id)
VALUES (1, 1),(4,2);

INSERT INTO comments (id, ticket_id, username, published, text)
VALUES (1, 1, 'user', '2023-05-21 23:29:15', 'Hello ,I have been waiting for a while, is there any updates on my ticket?');

INSERT INTO faq VALUES (1,'Forgot my password','You can reset your password by going to the login page and clicking "Forgot password"');
INSERT INTO faq VALUES (2,'I want to cancel my order', 'You can cancel the order on the profile page');
INSERT INTO faq VALUES (3,'What payment methods do you accept?', 'We accept Visa, Mastercard, American Express, and PayPal.');
INSERT INTO faq VALUES (4,'What is your return policy?', ' We offer a 30-day return policy for all products purchased from our website. If you are not satisfied with your purchase, you can return it for a full refund or exchange.');
INSERT INTO faq VALUES (5,' How do I track my order?', 'You will receive a tracking number via email once your order has shipped. You can use this tracking number to track the status of your order on our website.');
INSERT INTO faq VALUES (6,'How long does shipping take?','Shipping times vary depending on your location and the shipping method you choose. Standard shipping usually takes 3-5 business days, while express shipping takes 1-2 business days.');
INSERT INTO faq VALUES (7,'Can I cancel my order?','You can cancel your order as long as it has not yet been shipped. Please contact us as soon as possible if you need to cancel your order.');
INSERT INTO faq VALUES (8,'How do I contact customer support?','You can contact our customer support team by email, phone, or live chat. Our contact information is listed on our website.');
INSERT INTO faq VALUES (9,'Do you offer international shipping?','Yes, we offer international shipping to most countries. Shipping rates and delivery times vary depending on your location.');

COMMIT;