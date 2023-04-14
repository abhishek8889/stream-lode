@extends('host_layout.master')
@section('content')
<pre>
</pre>
<div class="container">
<table class="table table-striped projects">
             <tbody>
                @forelse($hostappoinments as $hostappoinments)
                 <tr>
                     <td>
                         <a href="">
                            You got a new appointment from {{ $hostappoinments->guest_name }} for {{ $hostappoinments->duration_in_minutes}} minutes 
                         </a>
                     </td>
                 </tr>
                 @empty
                 You have no notifications
                @endforelse 
             </tbody>
         </table>
</div>
@endsection