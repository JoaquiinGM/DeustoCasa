pipeline {
    agent any

    environment {
        REPO_URL = 'https://github.com/JoaquiinGM/DeustoCasa.git'
        BRANCH = 'main'
        WORK_DIR = '/home/joaquiingm/deustocasa/public_html'
    }

    stages {
        stage('Stop Containers') {
            steps {
                echo 'Stopping Docker containers...'
                sh '''
                    docker stop github-mysql || true
                    docker stop github-phpmyadmin || true
                    docker stop github-php-apache || true
                '''
            }
        }

        stage('Clean Directory') {
            steps {
                echo 'Removing contents of the directory...'
                sh '''
                    if [ -d "${WORK_DIR}" ]; then
                        rm -rf ${WORK_DIR}/*
                        rm -rf ${WORK_DIR}/.[!.]* || true # También elimina archivos ocultos
                    fi
                '''
            }
        }

        stage('Clone Repository') {
            steps {
                echo 'Cloning repository...'
                sh '''
                    git clone --branch ${BRANCH} ${REPO_URL} ${WORK_DIR}
                '''
            }
        }

        stage('Run Docker Compose') {
            steps {
                echo 'Running Docker Compose...'
                sh '''
                    cd ${WORK_DIR}
                    sudo docker-compose up -d
                '''
            }
        }
    }

    post {
        success {
            echo 'Pipeline executed successfully!'
        }
        failure {
            echo 'Pipeline failed. Please check the logs.'
        }
    }
}
