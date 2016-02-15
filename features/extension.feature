Feature: Extension Function Implementation
  In order to avoid using the extension directly
  As a library user
  I need to be able to perform all the extension functions through the class

  Rules:
  - Arguments should be identical to those for the extension functions
  - Return values should also be identical

  Scenario Outline: Compare functions to methods
    Given a scale of <scale>
    When I call BC::<method>(<args>)
    Then the return value should match bc<method>(<args>)

    Examples:
      | scale | method | args    |
      | 0     | add    | 1, 5    |
      | 18    | add    | 1, 5    |
      | 0     | comp   | 1, 5    |
      | 18    | comp   | 1, 5    |
      | 0     | div    | 1, 5    |
      | 18    | div    | 1, 5    |
      | 0     | mod    | 1, 5    |
      | 18    | mod    | 1, 5    |
      | 0     | mul    | 1, 5    |
      | 18    | mul    | 1, 5    |
      | 0     | pow    | 1, 5    |
      | 18    | pow    | 1, 5    |
      | 0     | powmod | 1, 5, 7 |
      | 18    | powmod | 1, 5, 7 |
      | 0     | scale  | 1       |
      | 18    | scale  | 1       |
      | 0     | sqrt   | 1       |
      | 18    | sqrt   | 1       |
      | 0     | sub    | 1, 5    |
      | 18    | sub    | 1, 5    |
