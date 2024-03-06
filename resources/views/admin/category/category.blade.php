@extends('layouts.dashboard')
@section('content')
<div class="">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                {{-- alert --}}
                @if (session('dlt'))
                    <div class="alert alert-danger"> {{session('dlt')}} </div>
                @endif
                {{-- alert --}}
                <div class="card-header">
                    <h2>Category List</h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Category</th>
                            <th>Added By</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($categories as $category )
                            
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$category->category_name}}</td>
                            <td>
                                @if (App\Models\User::where('id', $category->added_by)->exists())
                                  {{$category->rel_to_user->name}}
                                @else
                                    Unknown
                                @endif
                            </td>
                            <td><img width='50' src="{{asset('uploads/category')}}/{{$category->category_image}}  " alt=""></td>
                            <td>{{$category->created_at->diffForHumans()}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"href="{{ route('category.edit',$category->id) }}" >Edit</a>
                                        <a class="dropdown-item" href="{{ route('category.delete',$category->id) }}">Delete</a>
                                    </div>
                                </div>
                                {{-- <a href="{{ route('category.edit',$category->id) }}" class="btn btn-primary">Edit </a>
                                <a href="{{ route('category.delete',$category->id) }}" class="btn btn-danger">Delete </a> --}}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-primary"> {{session('success')}} </div>
                @endif
                <div class="card-header">
                    <h2>
                        Add Category
                    </h2>
                </div>
                <div class="card-body">
                    <form Action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @php
                            $icons = [
                                                              
                                'fa-music',                              
                                'fa-search',                             
                                                    
                                'fa-user',                               
                                'fa-film',                               
                                                     
                                'fa-th-list',                            
                                'fa-check',                              
                                'fa-times',                              
                                                  
                                'fa-signal',                             
                                'fa-cog',                                
                                                         
                                'fa-home',                               
                                                          
                                                       
                                         
                                'fa-list-alt',                           
                                'fa-lock',                               
                                'fa-flag',                               
                                'fa-headphones',                         
                                                    
                                'fa-book',                               
                                                             
                                'fa-camera',                             
                                               
                                'fa-pencil',                             
                                'fa-map-marker',                         
                                                
                                'fa-play',                               
                                'fa-pause',                              
                                              
                                'fa-leaf',                               
                                'fa-fire',                               
                                'fa-eye',                                
                                        
                                'fa-plane',                              
                                'fa-calendar',                           
                                       
                                'fa-folder',                             
                                        
                                'fa-key',                                
                               
                                'fa-phone',                              
                                'fa-square-o',                           
                                                  
                                                 
                                'fa-credit-card',                        
                                'fa-rss',                                
                                'fa-hdd-o',                              
                                'fa-bullhorn',                           
                                'fa-bell',                               
                                            
                                         
                                                
                                'fa-scissors',                           
                                                    
                                'fa-paperclip',                          
                                'fa-floppy-o',                           
                                                          
                                                     
                                                   
                                                  
                                
                                'fa-money',                              
                                'fa-caret-down',                         
                                'fa-caret-up',                           
                                'fa-caret-left',                         
                                'fa-caret-right',                        
                                                       
                                'fa-comment-o',                          
                                                      
                                'fa-desktop',                            
                                'fa-laptop',                             
                                'fa-tablet',                             
                                'fa-mobile',                             
                                                      
                                                
                                                        
                                                        
                                                   
                                'fa-gamepad',                            
                                'fa-keyboard-o',                         
                                'fa-flag-o',                             
                                'fa-flag-checkered',                     
                                'fa-terminal',                           
                                           
                                             
                                'fa-paper-plane',                        
 
                            ];
                        @endphp
                        <div class="mb-2">
                            <label for="">Select Icon</label>
                            <div style="font-family:fontawesome;">
                                @foreach ($icons as $icon )
                                <i class="fa {{ $icon }}" data-icon="{{ $icon }}"></i>
                                @endforeach
                            </div>
                            <input type="text"  id="icon" class="form-control"  name="icon" placeholder="Icon">
                        </div>
                        <div class="mb-2">
                            <label for="">Category Name</label>
                            <input type="text" class="form form-control" name="category_name">
                        </div>
                            @error('category_name')
                                <strong class="text text-danger"> {{ $message}} </strong>
                            @enderror
                        <div class="mb-2">
                            <label for="">Category Image</label>
                            <input type="file" class="form form-control" name="category_image">
                        </div>
                        @error('category_image')
                        <strong class="text text-danger"> {{ $message}} </strong>
                        @enderror
                        <div class="pt-3">
                            <button type="submit" class="btn btn-primary">Add </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                @if (session('hard_dlt'))
                    <div class="alert alert-danger"> {{session('dlt')}} </div>
                @endif
                <div class="card-header">
                    <h2>Deleted Category List</h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Category</th>
                            <th>Added By</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($trash_category as $key=> $category )
                            
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$category->category_name}}</td>
                            <td>
                                @if (App\Models\User::where('id', $category->added_by)->exists())
                                  {{$category->rel_to_user->name}}
                                @else
                                    Unknown
                                @endif
                            </td>
                            <td><img width='50' src="{{asset('uploads/category')}}/{{$category->category_image}}  " alt=""></td>
                            <td>{{$category->created_at->diffForHumans()}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"href="{{ route('category.restore',$category->id) }}" >Restore</a>
                                        <a class="dropdown-item" href="{{ route('category.hard.delete',$category->id) }}">Delete</a>
                                    </div>
                                </div>
                                {{-- <a href="{{ route('category.restore',$category->id) }}" class="btn btn-primary">Restore </a>
                                <a href="{{ route('category.hard.delete',$category->id) }}" class="btn btn-danger">Delete </a> --}}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')
    <script>
        $('.fa').click(function(){
            var icon = $(this).attr('data-icon');
            $('#icon ').attr('value', icon);
        })
    </script>
@endsection