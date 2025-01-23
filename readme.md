POST http://localhost:8000/seeder для генерации данных для базы данных заново. Не успел переделать на GET. И защиту
на localhost убрать.
Так же пагинацию добавить не успел.

SQL запрос для БД.

``
CREATE TABLE employees (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           first_name VARCHAR(50) NOT NULL,
                           last_name VARCHAR(50) NOT NULL,
                           position VARCHAR(100),
                           email VARCHAR(100) UNIQUE,
                           phone VARCHAR(20),
                           notes TEXT,
                           manager_id INT DEFAULT NULL,
                           FOREIGN KEY (manager_id) REFERENCES employees (id) ON DELETE SET NULL
);
``


При нажатии на "Show Subordinates" показывается кто закреплен за этим пользователем.
На кнопке Edit мы можем пользователя редактировать и в поле manager_id указать за кем закрепить этого пользователя.
