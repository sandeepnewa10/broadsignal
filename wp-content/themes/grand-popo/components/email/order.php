<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <style type="text/css">
        body {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        margin: 0 !important;
        width: 100% !important;
        -webkit-text-size-adjust: 100% !important;
        -ms-text-size-adjust: 100% !important;
        -webkit-font-smoothing: antialiased !important;
        background: #d1d3d4;
        font-family: 'Open Sans', sans-serif;
        }
        .tableContent img {
        border: 0 !important;
        display: block !important;
        outline: none !important;
        }
        a, .main-wrapper a {
        color: #000;
        text-decoration: none!important;
        border: 0!important;
        }
        p,
        h1,
        h2,
        li,
        div {
        margin: 0;
        padding: 0;
        }
        h1,
        h2 {
        font-weight: normal;
        background: transparent !important;
        border: none !important;
        font-weight: 600;
        color: #53588f;
        }
        table,
        tbody,
        tr,
        td {
        padding: 0;
        vertical-align: top;
        }
        img {
        width: 100%;
        max-width: 100%;
        height: auto;
        }
        .main-wrapper {
        background: #ffffff;
        max-width: 600px;
        width: 100%;
        }
        .main-wrapper table {
        width: 100%;
        }
        .left-border {
        width: 20px;
        display: inline-block;
        min-height: 20px;
        }
        .right-border {
        width: 20px;
        display: inline-block;
        min-height: 20px;
        }
        .header-section {
        border-bottom: 1px solid #EEEEEE;
        padding-bottom: 20px;
        padding-top: 20px;
        }
        .header-section .logo {
        max-width: 300px;
        margin-left: auto;
        margin-right: auto;
        }
        .broadsignal-wrapper {
        overflow: hidden;
        clear: both;
        padding: 20px;
        border: 1px solid #EEEEEE;
        border-radius: 6px;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        }
        .customer-info {
        padding: 30px 0;
        border-bottom: 1px solid #EEEEEE;
        }
        .customer-info .col-row,
        .order-info .col-row {
        overflow: hidden;
        clear: both;
        margin-bottom: 10px;
        }
        .customer-info .col-row .col-left {
        float: left;
        width: 230px;
        font-family: 'Open Sans', sans-serif;
        font-weight: 600;
        }
        .customer-info .col-row .col-right {
        float: left;
        font-family: 'Open Sans', sans-serif;
        font-weight: 400;
        }
        .order-info {
        padding: 30px 0 10px;
        }
        .order-info .col-row .col-left,
        .order-info .col-sm-4 {
        float: left;
        width: 230px;
        font-family: 'Open Sans', sans-serif;
        font-weight: 600;
        }
        .order-info .col-row .col-right,
        .order-info .col-sm-8 {
        float: left;
        font-family: 'Open Sans', sans-serif;
        font-weight: 400;
        }
        .order-info ul.order-list, .order-info ul {
        list-style: circle !important;
        padding-left: 17px  !important;
        }
        .order-info ul.order-list>li {
        text-indent: -5px;
        }
        .order-info ul.order-list>li:before {
        content: "-";
        text-indent: -5px;
        padding-right: 10px;
        }
        .order-info>div{
        overflow: hidden;
        clear: both;
        margin-bottom: 10px; }
        .order-info>div> label{
        float: left;
        width: 230px;
        font-family: 'Open Sans', sans-serif;
        font-weight: 600;
        }
        .order-info>div>div{
        float: left;
        font-family: 'Open Sans', sans-serif;
        font-weight: 400;
        clear: none;
        margin-bottom: 0;
        }
        </style>
</head>

<body>
    <table cellpadding="0" cellspacing="0" align="center" width="600" border="0" class="  main-wrapper">
        <tbody>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" align="center" border="0">
                        <tbody>
                            <tr style="height: 20px;">
                                <td width="20px" class="  left-border">
                                </td>
                                <td>
                                </td>
                                <td width="20px" class="  right-border">
                                </td>
                            </tr>
                            <tr>
                                <td width="20px" class="  left-border">
                                </td>
                                <td>
                                    <div class="  broadsignal-wrapper">
                                        <header class="  header-section">
                                            <div class="  logo"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo.png" alt=""></div>
                                        </header>
                                        <div class="  customer-info">
                                            <div class="  col-row">
                                                <h2>Customer Details</h2>
                                            </div>
                                            <div class="  col-row">
                                                <div class="  col-left">First Name:</div>
                                                <div class="  col-right">{{ firstname }}</div>
                                            </div>
                                            <div class="  col-row">
                                                <div class="  col-left">Last Name:</div>
                                                <div class="  col-right">{{ lastname }}</div>
                                            </div>
                                            <div class="  col-row">
                                                <div class="  col-left">Email:</div>
                                                <div class="  col-right">{{ email }}</div>
                                            </div>
                                            <div class="  col-row">
                                                <div class="  col-left">Mobile:</div>
                                                <div class="  col-right">{{ mobile }}</div>
                                            </div>
                                            <div class="  col-row">
                                                <div class="  col-left">Phone:</div>
                                                <div class="  col-right">{{ phone }}</div>
                                            </div>
                                            <div class="  col-row">
                                                <div class="  col-left">Address Line 1</div>
                                                <div class="  col-right">{{ address1 }}</div>
                                            </div>
                                            <div class="  col-row">
                                                <div class="  col-left">Address Line 2</div>
                                                <div class="  col-right">{{ address2 }}</div>
                                            </div>
                                            <div class="  col-row">
                                                <div class="  col-left">Suburb:</div>
                                                <div class="  col-right">{{ suburb }}</div>
                                            </div>
                                            <div class="  col-row">
                                                <div class="  col-left">Postal Code:</div>
                                                <div class="  col-right">{{ postal }}</div>
                                            </div>
                                            <div class="  col-row">
                                                <div class="  col-left">State:</div>
                                                <div class="  col-right"> {{ state }}</div>
                                            </div>
                                        </div>
                                        <div class="  order-info">
                                            <div class="col-row">
                                                    <h2>Order Details</h2>
                                                </div>
                                            {{ orderdetails }}
                                        </div>
                                    </div>
                                </td>
                                <td width="20px" class="  right-border">
                                </td>
                            </tr>
                            <tr style="height: 20px;">
                                <td width="20px" class="  left-border">
                                </td>
                                <td>
                                </td>
                                <td width="20px" class="  right-border">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>