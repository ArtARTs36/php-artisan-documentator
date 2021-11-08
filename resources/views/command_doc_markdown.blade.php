# Console Commands

@foreach($groups as $group)
## {{ $group['name'] }}

|  Command |  Description | Signature  |
| ------------ | ------------ | ------------ |
@foreach($group['commands'] as $command)
|  {{ $command['name'] }} | {{ $command['description'] }}  | {!! str_replace(['|', "\n"], ['&#124;', '<br>'], $command['signature']) !!}  |
@endforeach
@endforeach
