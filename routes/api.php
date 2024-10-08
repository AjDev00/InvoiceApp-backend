<?php

use App\Http\Controllers\DraftController;
use App\Http\Controllers\DraftItemController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//inserting drafts.
Route::post('drafts', [DraftController::class, 'store']);

//inserting item-drafts.
Route::post('draft-item', [DraftItemController::class, 'store']);

//inserting invoices.
Route::post('invoices', [InvoiceController::class, 'store']);

//inserting item-list.
Route::post('item-list', [ItemListController::class, 'store']);

//getting all invoices.
Route::get('invoices', [InvoiceController::class, 'index']);

//getting all drafts.
Route::get('drafts', [DraftItemController::class, 'index']);

//show a single invoice.
Route::get('show-invoice/{id}', [InvoiceController::class, 'show']);

//show a single draft.
Route::get('show-drafts/{id}', [DraftItemController::class, 'show']);

//delete a single invoice.
Route::delete('delete-invoice/{id}', [InvoiceController::class, 'destroy']);

//delete a single draft.
Route::delete('delete-draft/{id}', [DraftItemController::class, 'destroy']);

//edit a single invoice.
Route::put('edit-invoice/{id}', [InvoiceController::class, 'update']);

//edit a single item-list.
Route::put('edit-item/{invoice_id}', [ItemListController::class, 'update']);

//get item list with invoice id.
Route::get('get-item-list/{invoice_id}', [ItemListController::class, 'index']);

//delete a single item-list.
Route::delete('delete-item/{id}', [ItemListController::class, 'destroy']);

//get draft item with draft id.
Route::get('get-draft-item/{draft_id}', [DraftController::class, 'index']);

//update a single draft.
Route::put('edit-draft/{id}', [DraftController::class, 'update']);

//update a single draft-item.
Route::put('edit-draft-item/{draft_id}', [DraftItemController::class, 'update']);