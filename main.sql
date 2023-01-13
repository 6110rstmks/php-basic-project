CREATE TABLE members (
  id INT NOT NULL AUTO_INCREMENT,
  name_sei VARCHAR(255) NOT NULL,
  name_mei VARCHAR(255) NOT NULL,
  gender INT NOT NULL,
  pref_name VARCHAR(255) NOT NULL,
  address VARCHAR(255) NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  updated_at TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  deleted_at TIMESTAMP NULL,
  PRIMARY KEY (id)
);

