Feature: Refinery 29 - Biossance

  As a saucey developer
  I want to test Refinery 29 - Biossance 640x480 Tags
  So that I can pass it

  @javascript @R29_Biossance_640x480_Interstitial
  Scenario: Refinery 29 - Biossance 640x480 Interstitial
    Given I am on "http://demo.adcade.com/refinery29/biossance/2015/biossance/index.html"
    And I set my browser window size to "2800" x "1800"
    And I wait 5 seconds for "body" element
    #Test closing the interstitial
    When I tap "1280" x "420" coordinates
    And I reload the page
    And I wait for 3 seconds
    #Test mute/unmute
    When I tap "1245" x "865" coordinates
    And I wait for 15 seconds

  @javascript @R29_Biossance_640x480_Interstitial_IE8
  Scenario: Deloitte Crisis 2015 300x250 IE8 -- Web
    Given I am on "http://demo.adcade.com/refinery29/biossance/2015/biossance/index.html"
    Then the response should contain "https://ad.adcade.com/2/backup/ext/5e729b47-3a82-4e5d-bcf8-c0c47b1cd752/pl/ab076256-fd32-4757-b1b5-270057a330e8/"

  @javascript @R29_Biossance_640x480_Interstitial_Metrics
  Scenario: Deloitte Crisis 2015 300x250 Web Metrics
    Given I am on "http://adcade.dev/client/#anonymous"
    And I go to network tab
    And I wait for 30 seconds
    And I select request 1
    And I am on the network header tab
    Then the response should contain "imp"
    And the response should contain "GET"
    And the response should contain "5e729b47-3a82-4e5d-bcf8-c0c47b1cd752"
    When I select request 2
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.auto.expansion"
    And the response should contain "POST"
    And the response should contain "5e729b47-3a82-4e5d-bcf8-c0c47b1cd752"
    When I select request 3
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.auto.video.mute.main"
    And the response should contain "POST"
    And the response should contain "5e729b47-3a82-4e5d-bcf8-c0c47b1cd752"
    When I select request 4
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.auto.video.start.main"
    And the response should contain "POST"
    And the response should contain "5e729b47-3a82-4e5d-bcf8-c0c47b1cd752"
    When I select request 5
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.auto.video.1st_quartile.main"
    And the response should contain "POST"
    And the response should contain "5e729b47-3a82-4e5d-bcf8-c0c47b1cd752"
    When I select request 6
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "tdn"
    And the response should contain "POST"
    And the response should contain "5e729b47-3a82-4e5d-bcf8-c0c47b1cd752"
    When I select request 7
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.interact.close"
    And the response should contain "POST"
    And the response should contain "5e729b47-3a82-4e5d-bcf8-c0c47b1cd752"
    When I select request 8
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.auto.expansion"
    And the response should contain "POST"
    And the response should contain "5e729b47-3a82-4e5d-bcf8-c0c47b1cd752"
    When I select request 9
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "tdn"
    And the response should contain "POST"
    And the response should contain "5e729b47-3a82-4e5d-bcf8-c0c47b1cd752"
    When I select request 10
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.interact.video.unmute.main"
    And the response should contain "POST"
    And the response should contain "5e729b47-3a82-4e5d-bcf8-c0c47b1cd752"
    When I select request 11
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.auto.video.1st_quartile.main"
    And the response should contain "POST"
    And the response should contain "5e729b47-3a82-4e5d-bcf8-c0c47b1cd752"
    When I select request 12
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.auto.video.2nd_quartile.main"
    And the response should contain "POST"
    And the response should contain "5e729b47-3a82-4e5d-bcf8-c0c47b1cd752"
    When I select request 13
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.auto.video.3rd_quartile.main"
    And the response should contain "POST"
    And the response should contain "5e729b47-3a82-4e5d-bcf8-c0c47b1cd752"
    When I select request 14
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.auto.video.complete.main"
    And the response should contain "POST"
    And the response should contain "5e729b47-3a82-4e5d-bcf8-c0c47b1cd752"
    When I select request 15
    And I am on the network header tab
    Then the response should contain "event"
    And the response should contain "std.auto.close"
    And the response should contain "POST"
    And the response should contain "5e729b47-3a82-4e5d-bcf8-c0c47b1cd752"

  #@javascript @test @sample
  #Scenario: Test new step definitions here
    #Given I am on "http://127.0.0.1:7890/client/#anonymous"
    #And I go to network tab
    #And I wait for 60 seconds
    #And I scroll to the top
    #And I select request 1
