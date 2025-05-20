CREATE TABLE admin (
    admin_id INTEGER PRIMARY KEY AUTOINCREMENT,
    admin_name VARCHAR(200) NOT NULL,
    admin_password VARCHAR(255) NOT NULL
);

CREATE TABLE course(
    course_id INTEGER PRIMARY KEY AUTOINCREMENT,
    course_name VARCHAR(255) NOT NULL ,
    course_text VARCHAR(2000) NOT NULL,
    course_difficulty INT NOT NULL

);


INSERT INTO admin (admin_id,admin_name, admin_password) VALUES (1,'admin', 'admin');
INSERT INTO course (course_id,course_name,course_text,course_difficulty) VALUES (1,'Basics - Setting pointer fingers','j fj fjj jjf f'||
                                                                                                                      ' jjf jf f',1);
INSERT INTO course (course_id,course_name,course_text,course_difficulty) VALUES (2,'Basic sentence','Dont forget to feed the dog',1);
INSERT INTO course (course_id,course_name,course_text,course_difficulty) VALUES (3,'Test course','This is a simple text to train ' ||
                                                                                                 'fast typing on keyboard good luck mate',1);
INSERT INTO course (course_id,course_name,course_text,course_difficulty) VALUES (4,'Fast Editing','Editing text while maintaining speed and precision, eliminating spelling errors ',2);
INSERT INTO course (course_id,course_name,course_text,course_difficulty) VALUES (5,'Extend Vocabulary','Exploration of space, computer algorithms, impressionism in art, eliminating spelling errors ',2);
INSERT INTO course (course_id,course_name,course_text,course_difficulty) VALUES (6,'Punctuation','Punctuation is the use of spacing, conventional signs, and certain typographical devices as aids to the understanding and correct reading of written text, whether read silently or aloud',3);

INSERT INTO course (course_id,course_name,course_text,course_difficulty) VALUES (10,'Final Boss','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In fringilla mi ex. Nulla risus ipsum, vehicula at maximus vitae, suscipit non eros. Nulla finibus ante quis nisi vestibulum, sed aliquet felis consequat. Suspendisse potenti. Sed mollis volutpat erat. Donec vulputate ac justo et fermentum. Nam dapibus, arcu vel vehicula auctor, dui risus malesuada metus, at tristique urna mauris ut odio. Donec ac urna ut tellus blandit accumsan et at mauris. Curabitur erat elit, dictum nec mi quis, venenatis placerat justo. Ut vel risus eleifend, fermentum est in, gravida ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris gravida lectus ut faucibus fermentum. Mauris rutrum eleifend auctor. Mauris pulvinar in ligula eu convallis. Donec tincidunt euismod tortor, nec aliquam diam aliquet vitae. Morbi vulputate arcu libero, quis aliquet urna porttitor vitae. ',3);

