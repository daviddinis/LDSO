# Description
(Please provide a brief description of the user story)



# Acceptance tests
(Please provide an acceptance test following the [Gherking](https://cucumber.io/docs/gherkin/reference/) reference, see the examples below)


```gherkin
# This US has two important ACs
Feature: Viewing a car's profile page (example)

  Scenario 1: Given that I am on the login page
    When I enter my credentials and click login
    Then I should be brought to a dashboard page with cars in a grid
    When I click on one of the vehicles in the grid
    Then I should be brought to a page with detailed info about the car

  Scenario 2: Given that I am on the car profile page
    When I look at the this page
    Then I should be able to see: model, brand, total cost, and a list of associated expenses/taxes/ inspections/insurances
```


# Related stories (if any)
(If this user story is related to any other issues/stories, please link them here)
- See issue #...