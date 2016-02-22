Feature: Parse Method Implementation
  In order to use operator syntax (instead of function syntax)
  As a library user
  I need to be able to parse string operations into function calls

  Rules:
  - ???

  Scenario Outline: Compare functions to expected results
    Given a scale of <scale>
    When I call BC::parse(<args>)
    Then the return value should be <result>

    Examples:
      | scale | args           | result                 |
      | 0     | 1 + 5          | 6                      |
      | 18    | 1 + 5          | 6.000000000000000000   |
      | 0     | 1 - 5          | -4                     |
      | 18    | 1 - 5          | -4.000000000000000000  |
      | 0     | 1 * 5          | 5                      |
      | 18    | 1 * 5          | 5.000000000000000000   |
      | 0     | 1 / 5          | 0                      |
      | 18    | 1 / 5          | 0.200000000000000000   |
      | 0     | 1 % 5          | 1                      |
      | 18    | 1 % 5          | 1.000000000000000000   |
      | 0     | 5.5 %% 1       | 0                      |
      | 18    | 5.5 %% 1       | 0.500000000000000000   |
      | 0     | 1 ^ .5         | 1                      |
      | 18    | 1 ^ .5         | 1.000000000000000000   |
      | 0     | 1 = 5          | false                  |
      | 18    | 1 = 5          | false                  |
      | 0     | 1 == 5         | false                  |
      | 18    | 1 == 5         | false                  |
      | 0     | 1 > 5          | false                  |
      | 18    | 1 > 5          | false                  |
      | 0     | 1 < 5          | true                   |
      | 18    | 1 < 5          | true                   |
      | 0     | 1 >= 5         | false                  |
      | 18    | 1 >= 5         | false                  |
      | 0     | 1 <= 5         | true                   |
      | 18    | 1 <= 5         | true                   |
      | 0     | 1 <> 5         | true                   |
      | 18    | 1 <> 5         | true                   |
      | 0     | 1 != 5         | true                   |
      | 18    | 1 != 5         | true                   |
      | 0     | 1 & 5          | true                   |
      | 18    | 1 & 5          | true                   |
      | 0     | 1 && 5         | true                   |
      | 18    | 1 && 5         | true                   |
      | 0     | 1 \| 5         | true                   |
      | 18    | 1 \| 5         | true                   |
      | 0     | 1 \|\| 5       | true                   |
      | 18    | 1 \|\| 5       | true                   |
      | 0     | 1 ~ 5          | false                  |
      | 18    | 1 ~ 5          | false                  |
      | 0     | 1 ~~ 5         | false                  |
      | 18    | 1 ~~ 5         | false                  |
