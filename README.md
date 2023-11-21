# Task Manager PHP

Task Manager PHP is a robust task management application developed in PHP and MySQL. This application stands out by implementing vertical fragmentation, distributing data across two MySQL Docker databases on remote servers. This innovative approach enhances security and ensures a high data recovery rate.

## Features

- **Vertical Fragmentation:** Data is vertically fragmented and stored in separate MySQL Docker databases.
- **Enhanced Security:** Distributed data reduces security risks associated with centralized storage.
- **Improved Data Recovery:** The use of remote servers enhances data recovery capabilities.
- **Efficient Task Management:** Full-featured task management system for seamless organization.

## Technologies Used

- **Backend:** PHP, MySQL
- **Database:** MySQL (Docker)
- **Deployment:** Docker, Remote Servers
- **Security:** Vertical Fragmentation

## Getting Started

1. Clone the repository.
2. Set up the PHP and MySQL environment.
3. Configure database connections for remote MySQL Docker instances.
4. Run the application locally or deploy on remote servers.

## Usage

1. Register or log in to access the Task Manager.
2. Efficiently manage tasks using the intuitive user interface.
3. Experience enhanced security and data recovery with distributed, vertically fragmented databases.

# Task Manager PHP with Distributed Databases

Task Manager PHP is a powerful task management application developed in PHP and MySQL. This repository focuses on distributed databases using Docker, where the application utilizes two MySQL instances hosted on remote servers. This approach enhances security and improves data recovery.

## Docker Hub Repository

- **Docker Hub:** [Task Manager Docker Hub Repository](https://hub.docker.com/r/adityabattin2575/to_do_list)

## Docker Compose Configuration

### docker-compose.yml

```yaml
version: '3'

services:
  mysql1:
    image: mysql:latest
    container_name: todo_db1
    environment:
      MYSQL_ROOT_PASSWORD: rootuser
      MYSQL_DATABASE: todo_db
    ports:
      - "3308:3306"

  mysql2:
    image: mysql:latest
    container_name: todo_db2
    environment:
      MYSQL_ROOT_PASSWORD: rootuser
      MYSQL_DATABASE: todo_db
    ports:
      - "3309:3306"



## Contributing

Contributions are welcome! Feel free to submit issues or pull requests.

## License

This project is licensed under the [MIT License](LICENSE).

## Acknowledgments

- The project was inspired by the need for enhanced data security and recovery in task management applications.
- Thanks to the open-source community for providing valuable resources and inspiration.

```

# Project Images

<center>

![Image 1](/img/RepoImages/image1.jpg)

![Image 2](/img/RepoImages/image2.jpg)

![Image 3](/img/RepoImages/image3.jpg)

![Image 4](/img/RepoImages/image4.jpg)

![Image 5](/img/RepoImages/image5.jpg)

![Image 6](/img/RepoImages/image6.jpg)

</center>
