Feature: Deloitte Crisis 2015

  As a saucey developer
  I want to test Deloitte Crisis 2015 300x250 Tags
  So that I can pass it

  @javascript @DeloitteCrisis_2015_300x250
  Scenario: Deloitte Crisis 2015 300x250 Mobile Web
    Given I am on "http://demo.adcade.com/xaxis/bcbs/lets_talk_cost/300x250_mobile_app/index.html"
    And I set my browser window size to "2800" x "1800"
    And I wait 3 seconds for "body" element
    And I wait for 7 seconds
    #Move Left
    When I tap "860" x "260" coordinates
    And I wait for 3 seconds
    #Move Left
    When I tap "890" x "260" coordinates
    And I wait for 3 seconds
    #Play Video
    When I tap "950" x "200" coordinates
    And I wait for 30 seconds
    #Open Disclaimer
    And I tap "1060" x "350" coordinates
    And I wait for 3 seconds
    #Close Disclaimer
    And I tap "1060" x "350" coordinates
    #Test Drag Functionality
    And I initiate drag at "830" x "330" coordinates
    And I release drag at "1030" x "330" coordinates
    And I wait for 5 seconds



  @javascript @DeloitteCrisis_2015_300x250_Metrics
  Scenario: Deloitte Crisis 2015 300x250 Mobile Web Metrics
    Given I am on "http://127.0.0.1:7890/client/#anonymous"
    And I go to network tab
    And I wait for 60 seconds
    And I select request 1
    And I am on the network header tab
    Then the response should contain "imp"
    And the response should contain "GET"
    And the response should contain "XAXLTJ15APPBCBS300250MWV"
    When I select request 2
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "tdn"
    And the response should contain "POST"
    And the response should contain "XAXLTJ15APPBCBS300250MWV"
    When I select request 3
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.interact.navigate_left_answer_4"
    And the response should contain "POST"
    And the response should contain "XAXLTJ15APPBCBS300250MWV"
    When I select request 4
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "tdn"
    And the response should contain "POST"
    And the response should contain "XAXLTJ15APPBCBS300250MWV"
    When I select request 5
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.interact.navigate_left_answerLeftCTA_3"
    And the response should contain "POST"
    And the response should contain "XAXLTJ15APPBCBS300250MWV"
    When I select request 6
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "tdn"
    And the response should contain "POST"
    And the response should contain "XAXLTJ15APPBCBS300250MWV"
    When I select request 7
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.interact.video.play.video"
    And the response should contain "POST"
    And the response should contain "XAXLTJ15APPBCBS300250MWV"
    When I select request 8
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.auto.video.1st_quartile.video"
    And the response should contain "POST"
    And the response should contain "XAXLTJ15APPBCBS300250MWV"
    When I select request 9
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.auto.video.2nd_quartile.video"
    And the response should contain "POST"
    And the response should contain "XAXLTJ15APPBCBS300250MWV"
    When I select request 10
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.auto.video.3rd_quartile.video"
    And the response should contain "POST"
    And the response should contain "XAXLTJ15APPBCBS300250MWV"
    When I select request 11
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.auto.video.complete.video"
    And the response should contain "POST"
    And the response should contain "XAXLTJ15APPBCBS300250MWV"
    When I select request 12
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "tdn"
    And the response should contain "POST"
    And the response should contain "XAXLTJ15APPBCBS300250MWV"
    When I select request 13
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.interact.disclaimer_source"
    And the response should contain "POST"
    And the response should contain "XAXLTJ15APPBCBS300250MWV"
    When I select request 14
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "tdn"
    And the response should contain "POST"
    And the response should contain "XAXLTJ15APPBCBS300250MWV"
    When I select request 15
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.interact.disclaimer_close"
    And the response should contain "POST"
    And the response should contain "XAXLTJ15APPBCBS300250MWV"