/* Requires the Docker Pipeline plugin */
pipeline {
    agent any 
    stages {
        stage('Test') {
            steps {
                echo 'Hello World'
            }
        }
        // stage('SonarQube') {
        //    steps {
        //         script { scannerHome = tool 'Sonar scanner' }
        //         withSonarQubeEnv('SonarQube') {
        //             sh "${scannerHome}/bin/sonar-scanner -Dsonar.projectKey=OWS-Opdrachten"
        //         }
        //     }
        // }
    }
}