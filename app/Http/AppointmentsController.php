<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Requests\AppointmentRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Session;


class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

//    private $base_uri = 'http://localhost:8080/api/';
    private $base_uri = 'https://asimov-api.herokuapp.com/api/';


    public function index()
    {

        $data['calendar'] = $this->getCalendar();

        return view('appointments.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($start)
    {
        $data['appointment'] = Carbon::parse($start);
        return view('appointments.create', $data);
    }

    public function store(Request $request)
    {

        $client = new Client([
            'base_uri' => $this->base_uri,
            'timeout' => 10.0
        ]);



        $options = [
            'form_params' => [
                "name" => $request->name,
                "last_name" => $request->last_name,
                "email" => $request->email,
                "start" => Carbon::parse($request->start)->format('Y-m-d H:i:s'),
            ]
        ];

        $response = $client->request('POST', "appointments", $options);



        if (($response->getStatusCode() == 201)) {
            $data['calendar'] = $this->getCalendar();
            Session::flash('flash_message_ok', 'Record successfully created');
            return view('appointments.index', $data);
        } else {
            Session::flash('flash_message_error', 'Record unsuccessfully created');
            return redirect()->back();
        }


    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $client = new Client([
            'base_uri' => $this->base_uri,
            'timeout' => 2.0
        ]);

        $response = $client->request('GET', 'appointments/' . $id);
        $appointment = $response->getBody()->getContents();
        $data['appointment'] = json_decode($appointment, TRUE);

        return view('appointments.show', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = new Client([
            'base_uri' => $this->base_uri,
            'timeout' => 2.0
        ]);
        $response = $client->request('GET', 'appointments/' . $id . '/edit');
        $appointment = $response->getBody()->getContents();
        $data['appointment'] = json_decode($appointment, TRUE);
        return view('appointments.edit', $data);
    }

    public function update(AppointmentRequest $request, $id)
    {

        $client = new Client([
            'base_uri' => $this->base_uri,
            'timeout' => 2.0
        ]);


        $options = [
            'form_params' => [
                "name" => $request->name,
                "last_name" => $request->last_name,
                "email" => $request->email,
                "start" => Carbon::parse($request->start)->format('Y-m-d H:i:s'),
                'appointment_id' => $id
            ]
        ];

        $response = $client->request('POST', "appointments", $options);


        if ($response->getStatusCode() == 201) {
            $data['calendar'] = $this->getCalendar();
            Session::flash('flash_message_ok', 'Record successfully updated');
            return view('appointments.index', $data);
        } else {
            Session::flash('flash_message_error', 'Record unsuccessfully updated');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $client = new Client([
            'base_uri' => $this->base_uri,
            'timeout' => 2.0
        ]);


        $response = $client->delete($this->base_uri . 'appointments/' . $id);

        if (($response->getStatusCode() == 204)) {
            $data['calendar'] = $this->getCalendar();
            Session::flash('flash_message_ok', 'Record successfully deleted');
            return view('appointments.index', $data);
        } else {
            Session::flash('flash_message_error', 'Record unsuccessfully updated');
            return redirect()->back();
        }


    }

    private function getCalendar()
    {

        $client = new Client([
            'base_uri' => $this->base_uri,
            'timeout' => 2.0
        ]);
        $response = $client->request('GET', 'appointments');
        $appointments = $response->getBody()->getContents();
        $appointments = json_decode($appointments, TRUE);

        $events = [];
        foreach ($appointments as $appointment) {
            if ($appointment['user_id']) {
                $events[] = \Calendar::event(
                    "Appointment with " . $appointment['name'] . ' ' . $appointment['email'], //event title
                    false, //full day event?
                    $appointment['start'], //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                    $appointment['end'], //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
                    $appointment['id'], //optional event ID
                    [
                        'url' => url('appointments/' . $appointment['id']),
                        'backgroundColor' => 'red'
                        //any other full-calendar supported parameters
                    ]
                );
            } else {
                $events[] = \Calendar::event(
                    "The Death is available ", //event title
                    false, //full day event?
                    $appointment['start'], //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                    $appointment['end'], //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
                    $appointment['id'], //optional event ID
                    [
                        'url' => url('appointments/' . $appointment['id']),
                        'backgroundColor' => 'blue'
                        //any other full-calendar supported parameters
                    ]
                );
            }

        }

        $calendar = \Calendar::addEvents($events)
            ->setOptions([ //set fullcalendar options
                'firstDay' => 1,
                'themeSystem' => 'bootstrap3',
                'locale' => 'es'
            ]);

        return $calendar;

    }
}
