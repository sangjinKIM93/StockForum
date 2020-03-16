<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendar - Speed coding, Neat Developer</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="calendar/calendar.css">
    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/heroic-features.css" rel="stylesheet">
</head>
<body>
<!-- Navigation -->
<?php include 'menubar_lecture.php'; ?>
<div class="container">
<h3 style="text-align:center">퀀트/주식 강연</h3>

<input type="button" name="date_rank" value="달력으로 보기"  class="btn btn-outline-primary btn-sm" />
<input type="button" name="hit_rank" value="목록으로 보기"  class="btn btn-outline-primary btn-sm" onclick="location.href='lecture_main.php'"/> 
<br><br>

<div class="calendar disable-selection" id="calendar">
    <div class="left-side">
        <div class="current-day text-center">
            <h1 class="calendar-left-side-day"></h1>
            <div class="calendar-left-side-day-of-week"></div>
        </div>
        <div class="current-day-events">
            <div>Current Events:</div>
            <ul class="current-day-events-list"></ul>
        </div>
        <div class="add-event-day" style="display:none">
            <input type="text" class="add-event-day-field" placeholder="Create an Event">
            <span class="fa fa-plus-circle cursor-pointer add-event-day-field-btn"></span>
        </div>
    </div>
    <div class="right-side">
        <div class="text-right calendar-change-year">
            <div class="calendar-change-year-slider">
                <span class="fa fa-caret-left cursor-pointer calendar-change-year-slider-prev"></span>
                <span class="calendar-current-year"></span>
                <span class="fa fa-caret-right cursor-pointer calendar-change-year-slider-next"></span>
            </div>
        </div>
        <div class="calendar-month-list">
            <ul class="calendar-month"></ul>
        </div>
        <div class="calendar-week-list">
            <ul class="calendar-week"></ul>
        </div>
        <div class="calendar-day-list">
            <ul class="calendar-days"></ul>
        </div>
    </div>
</div>
</div><br><br>

<script async src="calendar/calendar.js"></script>
<!-- Bootstrap core JavaScript -->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>