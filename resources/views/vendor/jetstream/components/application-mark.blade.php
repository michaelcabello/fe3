<?php
echo '<?xml version="1.0" standalone="no"?>'; // Encerrar correctamente la declaración XML
?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 20010904//EN"
 "http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">

{{-- <img class="object-cover w-40 h-20 rounded-sm" src="{{asset('img/usuarios.jpg')}}" alt=""> --}}
@if(auth()->user()->employee->company->logo)
    <img class="object-cover w-20 h-10 rounded-sm"  src="{{ Storage::disk('s3')->url(auth()->user()->employee->company->logo) }}" alt="TICOM SOFTWARE">
@else

    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
    width="147.000000pt" height="49.000000pt" viewBox="0 0 147.000000 49.000000"
    preserveAspectRatio="xMidYMid meet">
    <metadata>
    Created by potrace 1.16, written by Peter Selinger 2001-2019
    </metadata>
    <g transform="translate(0.000000,49.000000) scale(0.100000,-0.100000)"
    fill="#000000" stroke="none">
    <path d="M70 353 l1 -38 15 28 c10 18 23 27 39 27 l25 0 0 -114 c0 -82 -4
    -116 -13 -119 -6 -3 15 -5 48 -5 33 0 54 2 48 5 -9 3 -13 37 -13 119 l0 114
    25 0 c16 0 29 -9 39 -27 l15 -28 1 38 0 37 -115 0 -115 0 0 -37z"/>
    <path d="M343 379 c15 -9 17 -26 17 -124 0 -100 -2 -114 -17 -118 -10 -3 11
    -5 47 -6 49 0 61 2 48 10 -15 9 -18 26 -18 119 0 93 3 110 18 119 13 8 1 10
    -48 10 -49 0 -61 -2 -47 -10z"/>
    <path d="M549 367 c-46 -30 -73 -87 -64 -134 15 -84 116 -134 192 -96 20 10
    39 25 41 33 4 12 0 11 -15 -3 -58 -51 -137 -21 -148 57 -14 91 19 146 86 146
    30 0 42 -6 63 -32 l26 -33 0 44 c0 33 -3 41 -12 33 -8 -5 -22 -6 -33 -1 -40
    16 -101 10 -136 -14z"/>
    <path d="M850 383 c-28 -10 -69 -56 -80 -89 -35 -106 85 -208 187 -157 54 26
    78 65 77 121 0 57 -23 95 -69 116 -32 16 -85 20 -115 9z m73 -12 c34 -13 51
    -69 44 -138 -7 -64 -28 -93 -68 -93 -44 0 -64 39 -64 123 0 63 2 71 28 93 32
    28 28 27 60 15z"/>
    <path d="M1084 375 c23 -23 23 -206 0 -229 -14 -15 -12 -16 22 -16 33 0 36 2
    21 13 -15 10 -17 27 -15 112 l3 99 44 -104 c24 -58 47 -109 51 -113 4 -4 26
    39 50 95 24 57 47 107 52 112 10 12 11 -175 0 -190 -4 -6 -14 -14 -22 -17 -8
    -3 14 -5 50 -5 36 0 59 2 53 5 -9 3 -13 37 -13 118 0 98 2 115 18 124 13 8 5
    10 -35 11 l-51 0 -32 -77 c-18 -43 -35 -82 -37 -86 -3 -5 -22 29 -42 75 l-37
    83 -48 3 c-45 3 -47 2 -32 -13z"/>
    </g>
    </svg>

@endif


{{-- {{ auth()->user()->employee->company->logo }} --}}


