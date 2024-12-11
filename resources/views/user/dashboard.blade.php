@extends('user.layouts.main')
@section('content')


<style>
    a#check_id {
    width: 20%;
    /* height: 100px; */
    font-size: 34px;
    margin-top: 15px;
    margin-bottom: 15px;
    text-align : center;
}
</style>

<div class="row">
    <div class="col-12 col-xl-12 mb-4">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-light shadow-sm">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                            <h2 class="h5">Mark Your Attendance</h2>
                            </div>
                            <!-- <div class="col text-right">
                                <a href="#" class="btn btn-sm btn-secondary">See all</a>
                            </div> -->
                        </div>
                    </div>
                    <div class="row">
                    @if($logout==null)
                        <div class="col-12 col-xl-12 text-center">
                        
                        <a href="{{route('check.in')}}" class="btn btn-primary" type="submit" id="check_id">Check IN</a>
                        </div>
                    @else

                        <div class="col-12 col-xl-12 text-center">
                        <a href="{{route('check.out',['id'=>$logout->atn_id])}}" class="btn btn-primary" id="check_id">Check Out</a>
                        </div>
                        @if($brlog==null)
                        <div class="col-12 col-xl-12 text-center">
                        <a href="{{route('break.in',['id'=>$logout->atn_id])}}" class="btn btn-primary" id="check_id">Break In</a>
                        </div>
                        @else
                        <div class="col-12 col-xl-12 text-center">
                        <a href="{{route('break.out',['id'=>$brlog->break_id])}}" class="btn btn-primary" id="check_id">Break Out</a>
                        </div>
                        @endif
                        
                    @endif
                        

                    
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
    
</div>


<div class="container">
    <div class="row">
        <div class="col-7 box box-8 ">

<!-- watch start --> 
<div class="container">
    <div class="row justify-content-around align-items-center">

    <div class="col-4">
<div class="clock-container">
        <div class="clock">
            <div class="needle hour"></div>
            <div class="needle minute"></div>
            <div class="needle second"></div>
            <div class="center-point"></div>
        </div>
        <div class="time"></div>
        <div class="date">
            <span class="circle"></span>
        </div>
    </div>

    </div>
<!-- watch end -->


    <div class="col-6 mt-4">
<!-- working hours button start -->
<div class="working-hoursmain mb-4">
<h1>Working Hours</h1>
<h1 id="workinghours"></h1>
</div>

<div class="working-hoursmain">
    <h1>Break Hours</h1>
    <h1 id="workinghours1"></h1>
</div>
<!-- working hours button end -->

<!-- buttons start -->
<!-- <button  type="button" class="btn btn-info d-flex align-items-center mt-4" style="width: 270px; gap:12px;"><i class="fa-solid fa-clock"></i>Time In</button> -->
<div class="d-flex mt-4" style="gap: 10px;">
<button type="button" class="btn btn-info d-flex align-items-center" style="width: 150px; gap:12px;"><i class="fa-solid fa-clock"></i>Time In</button>
<button type="button" class="btn btn-primary d-flex align-items-center" style="width: 150px; gap:12px;"><i class="fa-regular fa-circle-xmark"></i>Time Out</button>
</div>

<div class="d-flex mt-3" style="gap: 10px;">
<button type="button" class="btn btn-info d-flex align-items-center" style="width: 150px; gap:12px;"><i class="fa-solid fa-mug-saucer"></i>Break In</button>
<button type="button" class="btn btn-primary d-flex align-items-center" style="width: 150px; gap:12px;"><i class="fa-solid fa-outdent"></i>Break Out</button>
</div>
<!-- buttons end -->
    </div>

</div>
</div>

</div>
<!-- main first end -->
        


        <div class="col-5 box box-4">
        <!-- calendar start -->
        <div class="calendar-main">
    <div class="calendar-header">
        <button id="prevMonth"><i class="bi bi-chevron-left"></i></button>
        <span id="monthYear"></span>
        <button id="nextMonth"><i class="bi bi-chevron-right"></i></button>
    </div>
    <div class="calendar-body">
        <div class="calendar-day header">Sun</div>
        <div class="calendar-day header">Mon</div>
        <div class="calendar-day header">Tue</div>
        <div class="calendar-day header">Wed</div>
        <div class="calendar-day header">Thu</div>
        <div class="calendar-day header">Fri</div>
        <div class="calendar-day header">Sat</div>
    </div>
</div>
<!-- calendar end -->
        </div>
    </div>
</div>





<!-- feeds start -->
<a class="btn uploadbtn" href="#" role="button">Post Now</a>

<!-- upload part start -->
        <form id="postForm" class="card p-3 m-3 rounded shadow-sm ashar">
            <h5 class="card-title">Create a Post</h5>
            <div class="toolbar ">
                <button type="button" class="btn btn-outline-secondary"><i class="fas fa-bold"></i></button>
                <button type="button" class="btn btn-outline-secondary"><i class="fas fa-italic"></i></button>
                <button type="button" class="btn btn-outline-secondary"><i class="fas fa-underline"></i></button>
                <button type="button" class="btn btn-outline-secondary"><i class="fas fa-list-ol"></i></button>
                <button type="button" class="btn btn-outline-secondary"><i class="fas fa-list-ul"></i></button>
                <button type="button" class="btn btn-outline-secondary"><i class="fas fa-link"></i></button>
                <button type="button" class="btn btn-outline-secondary"><i class="fas fa-image"></i></button>
            </div>
            <div id="editor" class="editable" contenteditable="true" placeholder="What's on your mind?"></div>
            <div class="form-group mt-3">
                <input type="file" id="postImage" class="form-control-file">
            </div>
            <div class="mt-4">
            <button type="submit" class="btn btn-info">Post</button>
            <button type="submit" class="btn btn-danger">Cancel</button>
        </div>
        </form>
<!-- upload part end -->



<!-- display of post start -->
<div class="displaypost m-3 rounded" style="border: 1px solid rgb(207, 203, 203);">

<!-- user name and upload time shower -->
        <div class="d-flex align-items-center p-3 gap-4 bg-light rounded">
            <img src="./img1.jpg" class="rounded-circle" alt="User Avatar" style="height: 50px; width: 50px;">
            <div class="ml-3">
                <strong>Syed Ashar</strong><br>
                <small class="text-muted">Posted on Sep 6, 2024, 10:30 AM</small>
            </div>
        </div>
        <!-- user name and upload time shower -->


        <div class="card-body bg-white">
            <p>This is a sample post content. Lorem ipsum dolorOptio non iure quae quidem labore eaque adipisci at quaerat expedita dicta!</p>
            <img src="#" class="img-fluid rounded" alt="Post Image" style="height: 400px;">
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center bg-light">
            <div class="actions">
                <button class="btn btn-outline-primary btn-sm like-btn">
                    <i class="fas fa-thumbs-up"></i> Like
                </button>
                <button class="btn btn-outline-secondary btn-sm comment-btn">
                    <i class="fas fa-comment"></i> Comment
                </button>
            </div>
            <div class="counts text-muted">
                <span class="likes-count">0 Likes</span> · <span class="comments-count">0 Comments</span>
            </div>
        </div>

</div>
<!-- display of post end -->


<!-- feeds end -->










 @push('css')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>

 /* <!-- calendar style start --> */
        .calendar-main{
            width: 400px;
            margin: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .calendar-header {
            background-color: burlywood;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 1.5em;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .calendar-body {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border-top: 1px solid #ddd;
   
        }
        .calendar-day {
            text-align: center;
            padding: 8px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        .calendar-day.header {
            background-color: #e7ebee;
            font-weight: bold;
        }
        .calendar-day.today {
            background-color: #e9ecef;
            border: 1px solid #007bff;
        }
        .calendar-header button {
            background: none;
            border: none;
            color: white;
            font-size: 1.5em;
            cursor: pointer;
        }
        .calendar-header button:hover {
            color: #d3d3d3;
        }
/* <!-- calendar style end --> */

/* <!-- watch style start --> */
:root {
                --primary-color: #000;
                --secondary-color: #fff;
                --accent-color: #c47e24;
            --main-transition: all 0.5s ease-in;
        }
        .clock-container {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        .clock {
            position: relative;
            width: 200px;
            height: 200px;
            box-shadow: var(--accent-color) 0px 0px 50px;
            border-radius: 50%;
            margin: 20px 0;
        }

        .needle {
            background-color: var(--primary-color);
            box-shadow: var(--accent-color) 0px 0px 10px;
            position: absolute;
            top: 50%;
            left: 50%;
            height: 53px;
            width: 3px;
            transform-origin: bottom center;
            transition: var(--main-transition), transform 0s;
        }

        .needle.hour {
            transform: translate(-50%, -100%) rotate(0deg);
        }

        .needle.minute {
            transform: translate(-50%, -100%) rotate(0deg);
            height: 80px;
        }

        .needle.second {
            transform: translate(-50%, -100%) rotate(0deg);
            height: 80px;
            background-color: var(--accent-color);
        }

        .center-point {
            background-color: var(--primary-color);
            width: 10px;
            height: 10px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            transition: var(--main-transition);
        }

        .time {
            font-size: 40px;
        }

        .date {
            color: #aaa;
            font-size: 14px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .date .circle {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            border-radius: 50%;
            height: 18px;
            width: 18px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 18px;
            transition: var(--main-transition);
        }
 /* watch style end  */


 /* working hours start  */
.working-hoursmain{
    height: 80px;
padding: 10px 20px;
border-radius: 10px;
border: 2px solid gray;
}
.working-hoursmain h1{
    font-size: 20px;
}
/* working hours end */

/* feeds styling start */
.uploadbtn{
margin: 20px;
height: 40px;
background-color: var(--accent-color);
color: white;
width: 120px;
}

/* upload part start*/

.toolbar {
    margin-bottom: 10px;
}
.toolbar button {
    margin-right: 5px;
}
.editable {
    border: 1px solid #ced4da;
    border-radius: .25rem;
    padding: 10px;
    min-height: 200px;
    overflow-y: auto;
}
.editable:focus {
    outline: none;
    border-color: #80bdff;
}

/* upload part end */

/* feeds styling end */

</style>



@endpush
@push('js')

<!-- clendar js start -->

<script>
const calendarBody = document.querySelector('.calendar-body');
    const monthYearSpan = document.getElementById('monthYear');
    const prevMonthButton = document.getElementById('prevMonth');
    const nextMonthButton = document.getElementById('nextMonth');

    let currentDate = new Date();

    function renderCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();

        // Update the month and year display
        monthYearSpan.textContent = date.toLocaleString('default', { month: 'long' }) + ' ' + year;

        // Clear the previous days
        calendarBody.querySelectorAll('.calendar-day:not(.header)').forEach(day => day.remove());

        // Get the first day of the month
        const firstDay = new Date(year, month, 1).getDay();
        // Get the number of days in the month
        const lastDay = new Date(year, month + 1, 0).getDate();

        // Add empty cells for the days before the first day of the month
        for (let i = 0; i < firstDay; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.className = 'calendar-day';
            calendarBody.appendChild(emptyCell);
        }

        // Add the days of the month
        for (let i = 1; i <= lastDay; i++) {
            const dayCell = document.createElement('div');
            dayCell.className = 'calendar-day';
            dayCell.textContent = i;
            if (i === new Date().getDate() && month === new Date().getMonth() && year === new Date().getFullYear()) {
                dayCell.classList.add('today');
            }
            calendarBody.appendChild(dayCell);
        }
    }

    // Initialize the calendar
    renderCalendar(currentDate);

    // Event listeners for month navigation
    prevMonthButton.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    nextMonthButton.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

// calendar js end 

//  watch js start 
        const hourEl = document.querySelector(".hour");
        const minuteEl = document.querySelector(".minute");
        const secondEl = document.querySelector(".second");
        const timeEl = document.querySelector(".time");
        const dateEl = document.querySelector(".date");

        const days = [
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday"
        ];

        const months = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec"
        ];

        function setTime() {
            const time = new Date();
            const month = time.getMonth();
            const day = time.getDay();
            const date = time.getDate();
            const hours = time.getHours();
            const hoursForClock = hours % 12;
            const minutes = time.getMinutes();
            const seconds = time.getSeconds();

            hourEl.style.transform = `translate(-50%, -100%) rotate(${
                ((hoursForClock / 12) * 100 * 360) / 100
            }deg)`;

            minuteEl.style.transform = `translate(-50%, -100%) rotate(${
                ((minutes / 60) * 100 * 360) / 100
            }deg)`;

            secondEl.style.transform = `translate(-50%, -100%) rotate(${
                ((seconds / 60) * 100 * 360) / 100
            }deg)`;

            timeEl.innerHTML = `${hours}:${minutes < 10 ? `0${minutes}` : minutes}`;
            dateEl.innerHTML = `${days[day]}, ${months[month]} ${date}`;
        }

        setTime();

        setInterval(setTime, 1000);


let currentTime = new Date()
document.getElementById('workinghours').innerHTML=`${currentTime.getHours()} Hr ${currentTime.getMinutes()} Mins ${currentTime.getSeconds()} Sec`
document.getElementById('workinghours1').innerHTML=`${currentTime.getHours()} Hr ${currentTime.getMinutes()} Mins ${currentTime.getSeconds()} Sec`

// watch js end    

    </script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" rel="stylesheet">
<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script> -->

@endpush
@endsection