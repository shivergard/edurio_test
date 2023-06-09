## Senior backend developer
[Edurio](https://edurio.lv/) is a company that develops a solution for schools to survey their pupils, parents, and staff and to compare their results against benchmarks. As a Senior backend developer, your main responsibilities will be to contribute to the solution technical design, and architecture planning, to later with other developers write and deploy a reliable, efficient, and scalable code. At Edurio backend developers also write unit tests and integration tests and contribute to maintaining and improving the infrastructure. This task requires that you showcase your technical coding expertise and experience in constructing a database structure for a survey service. You will be assessed on your capacity to demonstrate these capabilities.
Requirements


## Programming language: PHP or Typescript (Framework: Laravel)
Database: pick the best for this task (that you would feel comfortable putting on production).

### Developer selection
As the primary consideration, I have opted to use PHP as the programming language, as it closely aligns with the existing infrastructure and allows me to provide precise development instructions for production. Furthermore, I am comfortable working with both PHP and Typescript, but I believe Laravel would be the most suitable framework for this project. In terms of the database selection, I will choose the best option based on the requirements of the project, and ensure that it is production-ready and reliable.

## Deliverables

### Deliverable 1. 

Prepare an Entity Relationship (ER) Diagram for a “Surveys” database.
Details: Surveys can be short (10 questions) or long (50 or more questions). The surveys database consists of different surveys, the questions that are in these surveys, and their answer options. For this task let’s consider that all surveys are in one language and without question routing (different paths).

### ER Diagram for Surveys
![image](docs/er.jpeg)
This project involves storing data in several tables, with the root table being Surveys that holds information on the survey and its status. The Questions table contains data on the questions and their order of appearance, while the Answers table stores possible answer options. Responses table captures the information or answers provided. Currently, there is no specified requirement to store user information, and hence, a string identifier is used in the 'respondent_ident' field, without creating an internal table for users. Similarly, it is not clear if this API service connects directly to the frontend or whether any user authentication or session storage is needed, and as such, no user operations have been implemented.

### Deliverable 2.
Build an API with the necessary endpoints for a survey model. Details: Choose how many endpoints you need to implement this task. The API needs to be able to:
1) Save respondent answers for one survey with 10 questions. Provide tests for respondent answer saving.
a. 9ofthesequestionshave5answeroptions(scalarvalues0–4).
You can use “Question 1”, “Question 2” as questions and “Answer 1”, “Answer 2” as answers instead of realistic questions and answers for this task. An example of this question would be “How often do you feel overworked?” with answer options (0:” Very often”; 1:” Quite often”; 2:” Sometimes”; 3:” Rarely”;
4:” Never”).
b. 1 of these questions is an open-answer question (free text entry).
An example of this question would be “Please name two things that you appreciate about your workplace” with one text field where respondents can type their response.
2) Provide results aggregation for the questions with 5 scalar answer options.
a. Question average.
The question average is an average from the scalar values of all the answers submitted to this question transformed to be in an interval from 1 to 5 with one digit after the decimal point (e.g., 3.6).
b. Question answers count.
It shows the total number of answers submitted for this question (e.g., 473).
c. Answers per answer option.
For each of the 5 answer options provide how many respondents submitted this option (e.g., “Option 1: 38”)
Deliverable 2 will be evaluated based on:
1) Survey filling performance (how fast a large number of answers can be saved).
2) Clean code.
3) Test coverage - have a decent amount of tests to cover the green and the red
scenarios.
4) Production-ready – only the minimum necessary features can be implemented,
but the functionality that is built should be good to be published in production.
An alternative to Deliverable 2 can be a live coding session. Please inform your Edurio contact if you would prefer a live coding session.
Definitions
Survey. A survey is a set of questions that respondents can answer. There are many surveys on Edurio, they have a different number of questions. Let's consider for this task that all surveys are in one language without any question routing (different paths, based on the respondent’s previous answers) and all surveys are fully completed (answers to all questions are submitted).
Question. A question in this context includes the question text, a question type and answer. options (if applicable). Let’s consider for this task there are only 2 question types – multiple-choice questions (with several answer options from which the respondent can only choose one) and open-answer questions (with no answer options where respondents can type in their text response in a text field).
Answer option. An answer option in this context is one of the several options for the question that the respondent can select. There are no right or wrong answer options to surveys. Let’s consider for this task that all answer options are on a Likert scale (from negative to positive or in numbers from 0 to X - the number of responses).

## Deliverable 2 implementation
Project is not provided Production ready. Still lack of test coverage for Answers and Responses controllers. Missing functionality for Response storage and Agregation. 

# Setup notes
Install [Docker](https://www.docker.com/). Copy .env.examples to .env , update details , note that database credentials are mentioned in 2 seperated places , for Laravel and MariaDB configurations. Run ```docker compose up -d```, after that ```docker exec -it laravel-app bash```, from where ```composer install``` , ```php artisan migrate```. To run tests : ```./vendor/phpunit/phpunit/phpunit tests```. Preview Swagger Documentation you can in link "http://localhost:{SELECTED_PORT}/api/documentation" - please note that documentation is not fully covered.

