<?php

class JournalController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        // get all
        $journals = Journal::all();

        // load the view and pass the journals
        return View::make('journals.index')
                        ->with(array('journals' => $journals, 'title' => 'myJournal | Journal List'));
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
//        echo 'type='. Input::get('journal_type');exit;
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'title' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('journal/create')
                            ->withErrors($validator)
                            ->withInput(Input::except('password'));
        } else {
            // store
            $journal = new Journal;
            $journal->type = Input::get('type');
            $journal->date = Input::get('date');
            $journal->date_from = Input::get('date_from');
            $journal->date_to = Input::get('date_to');
            $journal->title = Input::get('title');
            $journal->description = Input::get('description');
            $journal->created_by = Auth::user()->id;
            $journal->save();

            // redirect
            Session::flash('flash_notice', 'Successfully created Journal!');
            return Redirect::to('/');
        }
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

        // show the view and pass the journal to it
        return View::make('journals.show')
                        ->with(array('journal' => $journal, 'title' => 'myJournal | Journal View'));
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
            'title' => 'required'
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
            $journal->date = Input::get('date');
            $journal->date_from = Input::get('date_from');
            $journal->date_to = Input::get('date_to');
            $journal->title = Input::get('title');
            $journal->description = Input::get('description');
            $journal->updated_by = Auth::user()->id;
            $journal->save();

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
