<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 3/3/2021
 * Time: 9:25 AM
 */
?>
@extends('_layout_shared._master')
@section('title','TDS - User Guidelines')
@section('styles')

    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        .input-group-addon {
            border-radius: 0px;
        }

        .table {
            table-layout:fixed;
            width:100%;
        }

        /*.table > thead > tr > th {*/
        /*    padding: 4px;*/
        /*    font-size: 12px;*/
        /*}*/

        /*.table > tbody > tr > td {*/
        /*    padding: 4px;*/
        /*    font-size: 11px;*/
        /*}*/

        body {
            color: black;
        }

        .help-block {
            color: red;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
        }

        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        input[type=file]::-webkit-file-upload-button {
            width: 0;
            padding: 0;
            margin: 0;
            -webkit-appearance: none;
            border: none;
            border: 0px;
        }

        x::-webkit-file-upload-button, input[type=file]:after {
            content: 'Browse...';
            /*background-color: blue;*/
            left: 76%;
            /*margin-left:3px;*/
            position: relative;
            -webkit-appearance: button;
            padding: 2px 8px 2px;
            border: 0px;
        }

        input {
            color: black;
            font-size: x-small;
        }

        .emp_info > thead > tr > th {
            text-align: center;
        }

        .cnt {
            text-align: center;
        }



        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        .rotated {
            writing-mode: tb-rl;
            transform: rotate(-180deg);
        }

    </style>

@endsection

@section('right-content')

    <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        User Guidelines
                    </label>
                </div>
                <div class="panel-body" style="padding-top: 2%">

                            <div class="row">
                                <span style="font-weight: bold"><h4 align="center"><u><b>Common Definitions for Development Groups</b></u></h4></span>
                            </div>

                            <div class="">
                                <h5><b>Group Executive Potential</b></h5>
                                <p>
                                    Members of a divisional or functional Management committee, they are identified as possible successors to a group executive committee position. Individuals should either have international assignment experience or express the willingness to be geographically mobile.
                                </p>
                            </div>
                            <div class="">
                                <h5><b>Executive Potential</b></h5>
                                <p>
                                    Senior Executives who are identified as possible successors to divisional or functional management committee position. Individuals should either have international assignment experience or express the willingness to be geographically mobile.
                                </p>
                            </div>
                            <div class="">
                                <h5><b>High Potential</b></h5>
                                <p>
                                    Individuals whose career spans more than 7 years of total professional experience. Currently in management positions (transversally or hierarchically). They demonstrate high performance and sustained success and can be expected to make two career moves (lateral or vertical) in an 8 year time frame.
                                </p>
                            </div>
                            <div class="">
                                <h5><b>Early Potential </b></h5>
                                <p>
                                    Individuals who are in the early stage of their employment, with limited or no line Management experience. They show success in their current role and begin to demonstrate leadership capability. They can be expected to rapidly assume broader responsibilities and to make two career moves in a 5-year time frame.
                                </p>
                            </div>
                            <div class="">
                                <h5><b>Expert</b></h5>
                                <p>
                                    Individuals who are acknowledged for their unique skills or know-how in their field are considered rare and extremely difficult to replace. Expert (Vs HP): if they spend more than 50% of their time in their expertise field.
                                </p>
                            </div>
                            <div class="">
                                <h5><b>Contributor</b></h5>
                                <p>
                                    The majority of employees who consistently meet or exceed expectations in terms of job requirements and contribution. They are well suited to their current position and can be expected to continue to develop progressively over time and may move one level upwards or laterally within the organization.
                                </p>
                            </div>
                            <div class="">
                                <h5><b>New entrant</b></h5>
                                <p>
                                    Individuals who are new to the company or to their position and for whom it is too early to assess consistent performance or potential. They should be positioned within a development group within the next talent cycle.
                                </p>
                            </div>
                            <div class="">
                                <h5><b>Concern</b></h5>
                                <p>
                                    Individuals who do not currently performing in line with the expectations or requirements of the position or do not demonstrate behavior aligned with the incepta values and culture. Reasons for concern may also be linked to the position itself (misalignment of competencies or objectives).
                                </p>
                            </div>

                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-info">
                {{--                <div class="panel-heading">--}}
                {{--                    <label class="text-default">--}}
                {{--                        User Guidelines--}}
                {{--                    </label>--}}
                {{--                </div>--}}
                <div class="panel-body" style="padding-top: 2%">

                    <div class="row">
                        <span style="font-weight: bold"><h4 align="center"><u><b>Potentials explained</b></u></h4></span>
                    </div>
                    <h5 style="color: #0f81cc"><b>The characteristics of individuals with potential can be grouped into four key areas</b></h5>

                    <div class="">
                        <h5><b>Agility</b></h5>
                        <p>
                            Agility is the ability to respond to changing circumstances, drawing on experience and adopting strategies to ensure a successful outcome. These individuals engage with change, making sense or complex situations. They have the ability to reflect on experiences and apply the learning to new and future situations.
                        </p>
                    </div>
                    <div class="">
                        <h5><b>Ability</b></h5>
                        <p>
                            Ability is the combination of the innate characteristics and learned skills an individual demonstrates day to day; specifically, this includes mental/cognitive ability, emotional intelligence, technical/functional skills and interpersonal skills.
                        </p>
                    </div>
                    <div class="">
                        <h5><b>Aspiration</b></h5>
                        <p>
                            Aspiration is the extent to which an individual wants or desires recognition, development, advancement and influence, rewards and on the job enjoyment.
                        </p>
                    </div>
                    <div class="">
                        <h5><b>Engagement</b></h5>
                        <p>
                            Engagement is an individual`s emotional and rational commitment, discretional effort (i.e the willingness to go ‘above and beyond’ the call of duty and their intent to stay with incepta.
                        </p>
                    </div>

                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-info">
                {{--                <div class="panel-heading">--}}
                {{--                    <label class="text-default">--}}
                {{--                        User Guidelines--}}
                {{--                    </label>--}}
                {{--                </div>--}}
                <div class="panel-body table-responsive" style="padding-top: 2%">

                    <table border="1" cellspacing="0" cellpadding="0" align="left" width="100%">
                        <tbody>
                        <tr>
                            <td width="77"  style="text-align: center">
                                <p align="center">
                                    <strong><span class="rotated"> High</span></strong>
                                </p>
                            </td>
                            <td width="190" valign="top" style="background-color: #ffdb99">
                                <p align="center">
                                    <strong>7</strong>
                                    <strong></strong>
                                </p>
                                <p align="center">
                                    Consistently produces exceptional results and
                                    high-performance ratings. Knows current job extremely well.
                                    Good fit to role.
                                </p>
                            </td>
                            <td width="15" valign="top">
                            </td>
                            <td width="197" valign="top" style="background-color: #ffdb99">
                                <p align="center">
                                    <strong>8</strong>
                                    <strong></strong>
                                </p>
                                <p align="center">
                                    Consistently produces exceptional results. Knows the job
                                    extremely well and motivated to enhance skills. Adapts to
                                    new situations.
                                </p>
                            </td>
                            <td width="15" valign="top">
                            </td>
                            <td width="278" valign="top" style="background-color: #ffdb99">
                                <p align="center">
                                    <strong>9</strong>
                                    <strong></strong>
                                </p>
                                <p align="center">
                                    Clearest example of high performance and potential. Has the
                                    ability to take on major stretch assignments in new areas
                                    and move into key positions. Will challenge the
                                    organization to provide growth opportunity.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="77" valign="top">
                                <p align="center">
                                    <strong></strong>
                                </p>
                            </td>
                            <td width="190" valign="top">
                            </td>
                            <td width="15" valign="top">
                            </td>
                            <td width="197" valign="top">
                            </td>
                            <td width="15" valign="top">
                            </td>
                            <td width="278" valign="top">
                            </td>
                        </tr>
                        <tr>
                            <td width="77" style="text-align: center">
                                <p align="center">
                                    <strong><span class="rotated">Medium</span></strong>
                                </p>
                            </td>
                            <td width="190" valign="top" style="background-color: #ffdb99">
                                <p align="center">
                                    <strong>4</strong>
                                    <strong></strong>
                                </p>
                                <p align="center">
                                    Consistently meets expectations. Knows current job well.
                                    Most effective in known role/environment.
                                </p>
                            </td>
                            <td width="15" valign="top">
                            </td>
                            <td width="197" valign="top" style="background-color: #ffdb99">
                                <p align="center">
                                    <strong>5</strong>
                                    <strong></strong>
                                </p>
                                <p align="center">
                                    Consistently meets expectations. Knows current job well and
                                    enhances skill as appropriate. Moderate adaptability to new
                                    situations.
                                </p>
                            </td>
                            <td width="15" valign="top">
                            </td>
                            <td width="278" valign="top" style="background-color: #ffdb99">
                                <p align="center">
                                    <strong>6</strong>
                                    <strong></strong>
                                </p>
                                <p align="center">
                                    Consistently meets expectations. Knows current job well and
                                    enhances skill as appropriate. Has the ability to take on
                                    new and different challenges on a consistent basis.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="77" valign="top">
                                <p align="center">
                                    <strong></strong>
                                </p>
                            </td>
                            <td width="190" valign="top">
                            </td>
                            <td width="15" valign="top">
                            </td>
                            <td width="197" valign="top">
                            </td>
                            <td width="15" valign="top">
                            </td>
                            <td width="278" valign="top">
                            </td>
                        </tr>
                        <tr>
                            <td width="77" style="text-align: center; padding-top: 2px" >
                                <p>
                                    <strong><span class="rotated"> Performance Low</span></strong>
                                </p>
                            </td>
                            <td width="190" valign="top" style="background-color: #ffdb99">
                                <p align="center">
                                    <strong>1</strong>
                                    <strong></strong>
                                </p>
                                <p align="center">
                                    Not delivering on results as expected. Action Plan required
                                    to address performance concern. May need to re-scope or
                                    re-assign.
                                </p>
                            </td>
                            <td width="15" valign="top">
                            </td>
                            <td width="197" valign="top" style="background-color: #ffdb99">
                                <p align="center">
                                    <strong>2</strong>
                                    <strong></strong>
                                </p>
                                <p align="center">
                                    Delivers result inconsistently due to skills/knowledge
                                    gaps; may be on learning curve; expected to succeed in
                                    time.
                                </p>
                            </td>
                            <td width="15" valign="top">
                            </td>
                            <td width="278" valign="top" style="background-color: #ffdb99">
                                <p align="center">
                                    <strong>3</strong>
                                    <strong></strong>
                                </p>
                                <p align="center">
                                    Yet to demonstrate performance, either on a new position or
                                    stretch assignment. Has previously demonstrated high
                                    performance/ potential with high level of engagement and
                                    aspiration.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="77" valign="top">
                                <p align="center">
                                    <strong></strong>
                                </p>
                            </td>
                            <td width="190" valign="bottom">
                                <p align="center">
                                    <strong>Potential Low</strong>
                                </p>
                            </td>
                            <td width="15" valign="bottom">
                                <p align="center">
                                    <strong></strong>
                                </p>
                            </td>
                            <td width="197" valign="bottom">
                                <p align="center">
                                    <strong>Medium</strong>
                                </p>
                            </td>
                            <td width="15" valign="bottom">
                                <p align="center">
                                    <strong></strong>
                                </p>
                            </td>
                            <td width="278" valign="bottom">
                                <p align="center">
                                    <strong>High</strong>
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </section>
        </div>
    </div>
@endsection
@section('footer-content')
{{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {});
    </script>
@endsection