<div class="cat physics">
    <div class="loader">
        <div class="wrapper">
            <div class="catContainer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 733 673" class="catbody">
                    <path fill="#212121"
                        d="M111.002 139.5C270.502 -24.5001 471.503 2.4997 621.002 139.5C770.501 276.5 768.504 627.5 621.002 649.5C473.5 671.5 246 687.5 111.002 649.5C-23.9964 611.5 -48.4982 303.5 111.002 139.5Z">
                    </path>
                    <path fill="#212121" d="M184 9L270.603 159H97.3975L184 9Z"></path>
                    <path fill="#212121" d="M541 0L627.603 150H454.397L541 0Z"></path>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 158 564" class="tail">
                    <path fill="#191919"
                        d="M5.97602 76.066C-11.1099 41.6747 12.9018 0 51.3036 0V0C71.5336 0 89.8636 12.2558 97.2565 31.0866C173.697 225.792 180.478 345.852 97.0691 536.666C89.7636 553.378 73.0672 564 54.8273 564V564C16.9427 564 -5.4224 521.149 13.0712 488.085C90.2225 350.15 87.9612 241.089 5.97602 76.066Z">
                    </path>
                </svg>
                <div class="text">
                    <span class="bigzzz">Z</span>
                    <span class="zzz">Z</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .cat {
        position: absolute;
        bottom: 4rem;
        right: 15rem;
        z-index: 999;
        cursor: crosshair;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .loader {
        width: fit-content;
        height: fit-content;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .wrapper {
        width: fit-content;
        height: fit-content;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .catContainer {
        width: 100%;
        height: fit-content;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .catbody {
        width: 80px;
    }

    .tail {
        position: absolute;
        width: 17px;
        top: 75%;
        /* smooth back-and-forth */
        animation: tail 2s ease-in-out infinite alternate;
        transform-origin: top center;
    }

    @keyframes tail {

        /* start tilted to one side */
        from {
            transform: rotate(20deg);
        }

        /* swing to the other side */
        to {
            transform: rotate(-20deg);
        }
    }


    .wall {
        width: 300px;
    }

    .text {
        display: flex;
        flex-direction: column;
        width: 50px;
        position: absolute;
        margin: 0px 0px 100px 120px;
    }

    .zzz {
        color: black;
        font-weight: 700;
        font-size: 15px;
        animation: zzz 2s linear infinite;
    }

    .bigzzz {
        color: black;
        font-weight: 700;
        font-size: 25px;
        margin-left: 10px;
        animation: zzz 2.3s linear infinite;
    }

    @keyframes zzz {
        0% {
            color: transparent;
        }

        50% {
            color: black;
        }

        100% {
            color: transparent;
        }
    }


    @media screen and (max-width: 1100px) {
        .cat {
            display: none;
        }
    }
</style>