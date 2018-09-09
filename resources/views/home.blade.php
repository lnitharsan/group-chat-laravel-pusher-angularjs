@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Create Group</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputGroupName">Group name</label>
                        <input type="text" class="form-control" ng-model="createUserForm.name" id="exampleInputGroupName" aria-describedby="groupNameHelp" placeholder="Enter group name">
                        <p ng-bind="name"></p>
                    </div>


                    <div class="form-group">
                        <label for="exampleInputListOfUser">Lists of users</label>
                        <ul class="list-group">
                            @if(isset($users))
                                @foreach($users as $user)
                                    <li class="list-group-item"> <input type="checkbox" ng-click="toggleSelection('{{$user->id}}')" value="{{$user->id}}"> {{$user->name}}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" ng-click="createUser()" class="btn btn-primary float-right">Submit</button>
                </div>
            </div>

            <ul class="list-group mt-3">
                <li class="list-group-item list-group-item-dark">
                    List of Groups
                </li>
                <li class="list-group-item c-pointer" ng-repeat="group in groups" ng-click="selectGroup(group)">
                    <% group.name %>
                </li>
            </ul>

            {{--<pre ng-bind="groups | json"></pre>--}}
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" ng-init="sGroup.name = 'Group Name'"><% sGroup.name %></div>

                <div class="card-body">
                    <div class="frame">
                        <pre ng-bind="conversations | json"></pre>
                        <ul></ul>
                        <div>
                            <form method="post" ng-submit="sendMessage()">
                            <div class="msj-rta macro">
                                <div class="text text-r" style="background:whitesmoke !important">
                                    <input class="mytext" placeholder="Type a message" ng-model="message"/>
                                </div>

                            </div>
                            <div style="">
                                <button class="btn btn-primary" type="submit">Send</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
