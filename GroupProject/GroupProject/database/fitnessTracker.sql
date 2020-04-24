CREATE TABLE User(
  user_ID INTEGER NOT NULL AUTO_INCREMENT,
  name VARCHAR(50),
  PRIMARY KEY (user_ID)
);

CREATE TABLE Workout(
  date_completed TIMESTAMP,
  user_ID INTEGER NOT NULL,
  type VARCHAR(50), /*textual description of workout eg squats*/
  duration INTEGER (3), /*store minutes, convert to HH:MM for website*/
  intensity CHAR(8), /*intensity light, moderate, vigorous*/
  PRIMARY KEY (date_completed, user_ID),
  UNIQUE (date_completed, user_ID),
  FOREIGN KEY (user_ID) REFERENCES User(user_ID)
);

CREATE TABLE Weight(
  date_logged TIMESTAMP NOT NULL,
  user_ID INTEGER NOT NULL,
  user_weight DECIMAL(4, 1), /*weight in format 000.0 eg 210.5*/
  PRIMARY KEY (date_logged, user_ID),
  UNIQUE (date_logged, user_ID),
  FOREIGN KEY (user_ID) REFERENCES User(user_ID)
);

CREATE TABLE FoodBeverage(
  item_name VARCHAR(50) NOT NULL,
  serving_size DECIMAL(12, 3), /*how many of a given unit is a single serving*/
  calories INTEGER(5),
  PRIMARY KEY (item_name)
);

CREATE TABLE Eats(
  date_consumed TIMESTAMP NOT NULL,
  user_ID INTEGER NOT NULL,
  item_name VARCHAR(50) NOT NULL,
  num_of_servings INTEGER NOT NULL DEFAULT 1,
  PRIMARY KEY (date_consumed, user_ID, item_name),
  UNIQUE (date_consumed, user_ID),
  FOREIGN KEY (user_ID) REFERENCES User(user_ID),
  FOREIGN KEY (item_name) REFERENCES FoodBeverage(item_name)
);

CREATE TABLE Nutrients(
  nutrient_name VARCHAR(50),
  recommended_daily DECIMAL(12, 3),
  macro_micro CHAR(5), /*choice of macro or micro nutrient could be a radio button on website*/
  PRIMARY KEY (nutrient_name)
);

CREATE TABLE NutritionalInfo(
  nutrient_name VARCHAR(50),
  item_name VARCHAR(50) NOT NULL,
  nutrient_amount DECIMAL(12, 3), /*amount of nutrient in millgrams*/
  PRIMARY KEY (nutrient_name, item_name),
  FOREIGN KEY (nutrient_name) REFERENCES Nutrients(nutrient_name),
  FOREIGN KEY (item_name) REFERENCES FoodBeverage(item_name)
);
