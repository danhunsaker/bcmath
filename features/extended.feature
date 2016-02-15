Feature: Extended Function Implementation
  In order to perform advanced operations
  As a library user
  I need to be able to call advanced methods directly

  Rules:
  - ???

  Scenario Outline: Compare functions to expected results
    Given a scale of <scale>
    When I call BC::<method>(<args>)
    Then the return value should be <result>

    Examples:
      | scale | method  | args               | result                 |
      | 0     | modfrac | 5.5, 1             | 0                      |
      | 18    | modfrac | 5.5, 1             | 0.500000000000000000   |
      | 0     | powfrac | 1, .5              | 1                      |
      | 18    | powfrac | 1, .5              | 1.000000000000000000   |
      | 0     | root    | 1, 5               | 1                      |
      | 18    | root    | 1, 5               | 1.000000000000000000   |
      | 0     | log     | 1                  | 0                      |
      | 18    | log     | 1                  | 0.000000000000000000   |
      | 0     | ln      | 1                  | 0                      |
      | 18    | ln      | 1                  | 0.000000000000000000   |
      | 0     | epow    | 1                  | 2                      |
      | 18    | epow    | 1                  | 2.7182818284590455     |
      | 0     | round   | 2.7182818284590455 | 3                      |
      | 8     | round   | 2.7182818284590455 | 2.71828183             |
      | 0     | fact    | 5                  | 120                    |
      | 18    | fact    | 5                  | 120.000000000000000000 |
      | 0     | max     | [1, 5]             | 5                      |
      | 18    | max     | [1, 5]             | 5.000000000000000000   |
      | 0     | min     | [1, 5]             | 1                      |
      | 18    | min     | [1, 5]             | 1.000000000000000000   |
