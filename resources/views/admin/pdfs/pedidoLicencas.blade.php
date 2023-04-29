<html>

<head>
    <style>
        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            background-color: lightblue;
            height: 50px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            background-color: lightblue;
            height: 50px;
        }

        main {
            page-break-after: always;
        }

        main:last-child {
            page-break-after: never;
        }
    </style>
</head>

<body>


    <main>
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="text-align: left">#</th>
                    <th  scope="col">Last</th>
                    <th  scope="col">First</th=>
                    <th  scope="col">Handle</th>
                </tr>
            </thead>
            <tbody>

                @for($i = 1; $i <= 100; $i++) <tr>
                    <td  scope="col">{{$i}}</td>
                    <td  scope="col">Mark</td>
                    <td  scope="col">Otto</td>
                    <td  scope="col">@mdo</td>
                    <td>
                        <header>header on each page </header>
                        
                    </td>
                    <td>
                    <footer>footer on each page {{$i}}</footer>
                    </td>
                    
                    </tr>
                  

                    @endfor;
            </tbody>
        </table>
    </main>
</body>

</html>