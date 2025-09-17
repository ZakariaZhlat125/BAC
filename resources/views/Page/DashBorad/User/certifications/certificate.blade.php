<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certificate of Appreciation</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .certificate {
            width: 600px;
            margin: 30px auto;
            padding: 60px;
            background: #fff;
            border: 1px solid #ccc;
            position: relative;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        /* Blue polygon-style side borders */
        .certificate::before,
        .certificate::after {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            width: 1200px;
            background: linear-gradient(135deg, #4a90e2, #2a5298);
            clip-path: polygon(0 0, 100% 15%, 100% 85%, 0 100%);
        }

        .certificate::before {
            left: 0;
        }

        .certificate::after {
            right: 0;
            transform: scaleX(-1);
        }

        .logo {
            margin-bottom: 10px;
        }

        .company {
            font-size: 18px;
            margin-bottom: 25px;
        }

        h1 {
            font-size: 36px;
            font-weight: bold;
            margin: 20px 0;
        }

        .subtitle {
            font-size: 14px;
            margin: 10px 0 30px;
        }

        .recipient {
            font-size: 28px;
            font-weight: bold;
            margin: 15px 0;
        }

        .details {
            font-size: 16px;
            margin: 10px 0 40px;
            line-height: 1.6;
            color: #333;
        }

        .date {
            margin: 25px 0 70px;
            font-size: 16px;
        }

        .signature {
            margin-top: 50px;
            font-size: 16px;
        }

        .signature span {
            display: block;
            margin-top: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="certificate">
        <!-- Placeholder Logo -->
        <div class="logo">
            <img src='assets/img/kfu_logo.png' alt="Company Logo">
        </div>
        <div class="company">King Faisal University</div>

        <h1>CERTIFICATE OF APPRECIATION</h1>

        <div class="subtitle">THIS CERTIFICATE IS GIVEN TO</div>

        <div class="recipient">{{ $certification->student->user->name }}</div>

        <div class="details">
            <p>Has successfully completed:</p>
            <h3>{{ $certification->hours }} Volunteer Hours</h3>

        </div>
        <p>Certificate Number: {{ $certification->certificate_number }}</p>
        <div class="date">Given this {{ $certification->created_at->format('Y-m-d') }}.</div>

        {{-- <div class="signature">
            Jason I. Figueroa <br>
            <span>Operations Manager</span>
        </div> --}}
    </div>
</body>

</html>
