<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
  public function index() {
    return view('listings.index', [
      'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(4),
      // 'listings' => Listing::latest()->filter(request(['tag', 'search']))->simplePaginate(4),
    ]);  
  }

  public function show(Listing $listing) {
    return view('listings.show', [
      'listing' => $listing
    ]);  
  }

  // Show the Create form
  public function create() {
    return view('listings.create');
  }

  // Store the Listing data
  public function store(Request $request) {
    $formFields = $request->validate([
      'title' => 'required',
      'company' => ['required', Rule::unique('listings', 'company')],
      'location' => 'required',
      'website' => 'required',
      'email' => ['required', 'email'],
      'tags' => 'required',
      'description' => 'required'
    ]);

    if($request->hasFile('logo')) {
      $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }
    
    $formFields['user_id'] = auth()->id();

    Listing::create($formFields);

    // Session::flash('message', 'Listing Created!');

    return redirect('/')->with('message', 'Listing created successfully!');
  }

  // Show the Edit form
  public function edit(Listing $listing) {
    return view('listings.edit', ['listing' => $listing]);
  }

  // Update the Listing data
  public function update(Request $request, Listing $listing) {
    // Make sure logged in User owner
    if($listing->user_id != auth()->id()) {
      abort(403, 'Unauthorized action!');
    }

    $formFields = $request->validate([
      'title' => 'required',
      'company' => ['required'],
      'location' => 'required',
      'website' => 'required',
      'email' => ['required', 'email'],
      'tags' => 'required',
      'description' => 'required'
    ]);

    if($request->hasFile('logo')) {
      $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }
    
    $listing->update($formFields);

    // Session::flash('message', 'Listing Created!');

    return back()->with('message', 'Listing updated successfully!');
  }

  // Delete the Listing
  public function delete(Listing $listing) {
    // Make sure logged in User owner
    if($listing->user_id != auth()->id()) {
      abort(403, 'Unauthorized action!');
    }

    $listing->delete();

    return redirect('/')->with('message', 'Listing deleted successfully!');
  }

  // Manage Listings
  public function manage() {
    return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
  }

}
