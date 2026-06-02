<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="https://arabhardware.net/events/ahw.png" sizes="any">
<link rel="icon" href="https://arabhardware.net/events/ahw.png" type="image/svg+xml">
<link rel="apple-touch-icon" href="https://arabhardware.net/events/ahw.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet">
<meta name="keywords" content="كأس العالم للأندية, FIFA 2025, توقعات, جوائز, عرب هاردوير, تحديات, كرة القدم" />

<meta name="description"
    content="شارك في تحديات كأس العالم للأندية FIFA 2025 على منصة عرب هاردوير واربح جوائز قيّمة!" />
<meta name="twitter:title" content="توقع نتائج كأس العالم للأندية 2025 واربح مع عرب هاردوير!" />
<meta name="twitter:site" content="https://gaming.arabhardware.net/" />
<meta name="twitter:creator" content="عرب هاردوير" />
<meta name="twitter:description"
    content="شارك في تحديات كأس العالم للأندية FIFA 2025 على منصة عرب هاردوير واربح جوائز قيّمة!" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:image" content="https://arabhardware.net/events/fifa_club_world_cup_2025.webp" />
<meta name="theme-color" content="#6F5D25" />
<meta property="og:url" content="https://gaming.arabhardware.net/" />
<meta property="og:title" content="توقع نتائج كأس العالم للأندية 2025 واربح مع عرب هاردوير!" />
<meta property="og:description"
    content="شارك في تحديات كأس العالم للأندية FIFA 2025 على منصة عرب هاردوير واربح جوائز قيّمة!" />
<meta property="og:type" content="website" />
<meta property="og:image" content="https://arabhardware.net/events/fifa_club_world_cup_2025.webp" />

<style>
    @property --scale {
        syntax: '<number>';
        inherits: true;
        initial-value: .8;
    }

    :root {
        --char-size: 20vmin;
        --speed: 10s;
    }

    /* body {
        height: 100vh;
        margin: 0;
        overflow: hidden;
        background: #1C2379;
        color: #fff;
    } */

    .logo-wc {
        height: 100vh;
        margin: 0;
        overflow: hidden;
        background: #1C2379;
        color: #fff;
        overflow: hidden;
        --r: calc(var(--char-size) / 3);
        --gap: calc(var(--char-size) / 15);

        display: grid;
        grid-template-rows: repeat(2, 1fr);
        gap: var(--gap);
        height: 100%;
    }

    .num {
        display: grid;
        justify-content: center;
    }

    .num-two {
        align-content: end;
        background: #EA394B;
    }

    .num-two span {
        transform-origin: 50% 100%;
    }

    .num-six {
        align-content: start;
        z-index: 0;
    }

    .num-six span {
        transform-origin: 50% calc(sibling-index() * .01%);
    }

    .num span {
        grid-row: 1;
        grid-column: 1;

        position: relative;

        display: block;
        width: calc(var(--r) * 4);
        height: calc(var(--r) * 3);

        container-type: size;
        z-index: calc(sibling-count() - sibling-index());

        &:not(:first-child) {
            scale: calc((sibling-index() - 1) * var(--scale));
            animation: scaleIt var(--speed, 0s) calc(sibling-index() * -100ms) ease-in-out infinite;
        }
    }

    .num span:nth-child(10n + 1) {
        color: #F1FE67;
    }

    .num span:nth-child(10n + 2) {
        color: #6B1D18;
    }

    .num span:nth-child(10n + 3) {
        color: #C3291C;
    }

    .num span:nth-child(10n + 4) {
        color: #AC89F7;
    }

    .num span:nth-child(10n + 5) {
        color: #374FF5;
    }

    .num span:nth-child(10n + 6) {
        color: #EB4F27;
    }

    .num span:nth-child(10n + 7) {
        color: #BCE949;
    }

    .num span:nth-child(10n + 8) {
        color: #5A0DE0;
    }

    .num span:nth-child(10n + 9) {
        color: #91FBDC;
    }

    .num span:nth-child(10n + 10) {
        color: #1E4B3F;
    }

    .num span:nth-child(1) {
        color: #fff;
    }

    .num span:before {
        content: '';
        position: absolute;
        inset: 0;
        background: currentcolor;
    }

    .num-two span:before {
        clip-path: shape(from 0 var(--r),
                arc to var(--r) 0 of var(--r) var(--r) cw,
                line to calc(var(--r) * 3) 0,
                arc to calc(var(--r) * 3) calc(var(--r) * 2) of var(--r) var(--r) cw,
                line to calc(var(--r) * 4) calc(var(--r) * 2),
                line to calc(var(--r) * 4) calc(var(--r) * 3),
                line to 0 calc(var(--r) * 3),
                line to 0 calc(var(--r) * 2),
                arc to var(--r) var(--r) of var(--r) var(--r) cw,
                close);
    }

    .num-six span:before {
        clip-path: shape(from 0 var(--r),
                arc to var(--r) 0 of var(--r) var(--r) cw,
                line to calc(var(--r) * 3) 0,
                arc to calc(var(--r) * 4) var(--r) of var(--r) var(--r) cw,
                line to calc(var(--r) * 3) var(--r),
                arc to calc(var(--r) * 3) calc(var(--r) * 3) of var(--r) var(--r) cw,
                line to var(--r) calc(var(--r) * 3),
                arc to 0 calc(var(--r) * 2) of var(--r) var(--r) cw,
                close);
    }

    .num-six span:first-child:after {
        content: 'TM';

        position: absolute;
        bottom: 0;
        left: 100%;

        rotate: -90deg;
        transform-origin: 0 100%;

        font-size: 8cqb;
        font-family: sans-serif;
        text-box: trim-both cap alphabetic;
    }

    .logo-wc img {
        position: absolute;
        top: 50%;
        left: 50%;
        z-index: 99;

        display: block;
        margin: 0;
        height: calc(var(--char-size) * 1.55);

        transform: translate(-50%, -50%);
    }

    @keyframes scaleIt {
        20% {
            --scale: 2;
        }

        40% {
            --scale: .6;
        }

        70% {
            --scale: 1.4;
        }
    }
</style>
@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
