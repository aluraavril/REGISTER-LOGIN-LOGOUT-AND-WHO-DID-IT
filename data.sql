
-- Users table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    age INT NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Color game table
CREATE TABLE color_game (
    color_id INT AUTO_INCREMENT PRIMARY KEY,
    color_name VARCHAR(50) NOT NULL,
    dealer_name VARCHAR(50) NOT NULL,
    added_by INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (added_by) REFERENCES users(user_id)
);

-- Bettors table
CREATE TABLE bettors (
    bettor_id INT AUTO_INCREMENT PRIMARY KEY,
    bettor_firstname VARCHAR(50) NOT NULL,
    betting_price INT NOT NULL,
    color_id INT NOT NULL,
    added_by INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (color_id) REFERENCES color_game(color_id) ON DELETE CASCADE,
    FOREIGN KEY (added_by) REFERENCES users(user_id)
);

-- Updates made on existing records 
UPDATE bettors SET added_by = (SELECT user_id FROM users LIMIT 1) WHERE added_by IS NULL;


ALTER TABLE bettors 
ADD COLUMN last_updated_by INT,
ADD FOREIGN KEY (last_updated_by) REFERENCES users(user_id);

ALTER TABLE color_game
ADD COLUMN last_updated_by INT,
ADD FOREIGN KEY (last_updated_by) REFERENCES users(user_id);
