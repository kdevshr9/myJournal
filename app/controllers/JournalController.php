<?php

class JournalController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        
        $journals = Journal::with('days')->get();
        $journal_days = Day::with('photos')->get();
        // load the view and pass the journals
        return View::make('journals.index')
                        ->with(array('journals' => $journals, 'journal_days' => $journal_days, 'title' => 'myJournal | Journal List'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return View::make('journals.create')->with('title', 'myJournal | New Journal');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
//        echo "<pre>";print_r($_POST);exit;
//        echo 'type='. Input::get('date');exit;
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'title' => 'required',
            'description' => 'required',
            'date' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('journal/create')
                            ->withErrors($validator)
                            ->withInput(Input::except('password'));
        } else {
            // store
            $journals = new Journal;
            $journals->type = Input::get('type');
            $journals->title = Input::get('title');
            $journals->created_by = Auth::user()->id;
            $journals->save();
            
//            $journal->journal_days()->save(array('journal_id'=>$journal->id, 'date'=>Input::get('date'), 'description'=>Input::get('description'), 'created_by'=>Auth::user()->id));
            
            $journal_locations = new journallocation;
            $journal_locations->journal_id = $journals->id;
            $journal_locations->latitude = Input::get('current_latitude');
            $journal_locations->longitude = Input::get('current_longitude');
            $journal_locations->formatted_address = Input::get('current_formatted_address');
            $journal_locations->save();
            
            $day = new Day;
            $day->journal_id = $journals->id;
            $day->date = Input::get('date');
            $day->description = Input::get('description');
            $day->created_by = Auth::user()->id;
            $day->save();
            
            $day_location_markers = Input::get('journal_day_location_markers');
            $day_location_marker_formatted_address = Input::get('journal_day_location_marker_formatted_address');
            $day_location_marker_name = Input::get('journal_day_location_marker_name');
            $day_photo_location = Input::get('journal_day_photo_location');
            $day_location_id = array();
            for ($i = 0; $i < count($day_photo_location); $i++){
                $day_location_id[$i] = '';
            }
            
            if($day_location_markers){
                foreach($day_location_markers as $day_location_key=>$day_location_lat_lng){
                    $day_locations = new daylocation;
                    $exploded_lat_lng = explode('_', $day_location_lat_lng);
                    $day_locations->day_id = $day->id;
                    $day_locations->latitude = $exploded_lat_lng[0];
                    $day_locations->longitude = $exploded_lat_lng[1];
                    $day_locations->formated_address = $day_location_marker_formatted_address[$day_location_key];
                    $day_locations->manual_address = $day_location_marker_name[$day_location_key];
                    $day_locations->created_by = Auth::user()->id;
                    $day_locations->save();
                    if($day_photo_location){
                        foreach($day_photo_location as $day_photo_location_key=>$location_name){
        //                    $day_location_id[$day_photo_location_key] = '';
                            if($location_name && $location_name == $day_location_marker_name[$day_location_key]){
                                $day_location_id[$day_photo_location_key] = $day_locations->id;
                            }
                        }
                    }
                }
            }

            $caption = Input::get('caption');
            $photo_name = Input::get('photo_name');
            if($caption){
                foreach($caption as $key=>$value){
                    $source = 'public/gallery_uploads/temp/' . Auth::user()->id . '/';
                    $destination = 'public/gallery_uploads/' . Auth::user()->id . '/' . $journals->id . '/';
                    if(!is_dir($destination)){
                        mkdir($destination, 0777, true);
                    }

                    if(copy($source.$photo_name[$key], $destination.$photo_name[$key])){
                        unlink($source.$photo_name[$key]);
                        $day_photo = new Photo;
                        $day_photo->day_id = $day->id;
                        $day_photo->daylocation_id = $day_location_id[$key];
                        $day_photo->caption = $value;
                        $day_photo->name = $photo_name[$key];
                        $day_photo->path = 'gallery_uploads/' . Auth::user()->id . '/' . $journals->id . '/';
                        $day_photo->created_by = Auth::user()->id;
                        $day_photo->save();
                    }
                }
            }
            // redirect
            Session::flash('flash_notice', 'Successfully created Journal!');
            return Redirect::to('/');
        }
    }
    
    public function post_upload() {
//        $input = Input::all();
//        $rules = array(
//            'file' => 'image|max:3000',
//        );
//
//        $validation = Validator::make($input, $rules);
//
//        if ($validation->fails())
//        {
//            return Response::make($validation->errors->first(), 400);
//        }
                
        $file = Input::file('file');
//        $destinationPath = 'public/gallery_uploads/' . Auth::user()->id;
        $destinationPath = 'public/gallery_uploads/temp/' . Auth::user()->id;
        $filename = str_random(6) . '_' .$file->getClientOriginalName();

        $uploadSuccsess = Input::file('file')->move($destinationPath, $filename);


        if ($uploadSuccsess) {
            return Response::json($filename, 200);
        } else {
            return Response::json('error', 400);
        }
    }
    
    public function post_delete(){
        $fileName = Input::get('fileName');
        $destinationPath = 'public/gallery_uploads/temp/' . Auth::user()->id . '/' . $fileName;
        unlink($destinationPath);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        // get the journal
        $journal = Journal::find($id);
        if($journal->type == 1){                        //IF SINGLE DAY
            $days = $journal->days()->first();
            $journallocations = $journal->journallocations()->first();
        }
//        $photos = $journal->photos()->get();
        $photos = Photo::where('day_id', '=', $days->id)->get();
        $daylocations = $journal->daylocations()->get();
//        dd(DB::getQueryLog());
//        exit;

        // show the view and pass the journal to it
        return View::make('journals.show')
                        ->with(array('journal' => $journal, 'days' => $days, 'journallocations' => $journallocations, 'photos' => $photos, 'daylocations' => $daylocations, 'title' => 'myJournal | Journal View'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        // get the journal
        $journal = Journal::find($id);

        // show the edit form and pass the journal
        return View::make('journals.edit')
                        ->with(array('journal' => $journal, 'title' => 'myJournal | Journal Edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $rules = array(
            'title' => 'required',
            'description' => 'required',
            'date' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('journal/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput(Input::except('password'));
        } else {
            // store
            $journal = Journal::find($id);
            $journal->type = Input::get('type');
            $journal->title = Input::get('title');
            $journal->latitude = Input::get('latitude');
            $journal->longitude = Input::get('longitude');
            $journal->updated_by = Auth::user()->id;
            $journal->save();
            
            $journal_day = array('date'=>Input::get('date'), 'description'=>Input::get('description'), 'updated_by'=>Auth::user()->id);
            $journal->days()->update($journal_day);
            
            // redirect
            Session::flash('flash_notice', 'Successfully updated Journal!');
            return Redirect::to('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        // delete
        $journal = Journal::find($id);
        $journal->delete();

        // redirect
        Session::flash('flash_notice', 'Successfully deleted the Journal!');
        return Redirect::to('/');
    }

}
