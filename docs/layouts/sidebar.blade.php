# RiotQuest
- [Home]()
- [Getting Started](Getting-Started)
- [Examples](Examples)

# The Basics
- [Creating the Client](Creating-the-Client)
- [Sending the Request](Sending-the-Request)
- [Handling the Response](Handling-the-Response)

# Endpoints
- [Endpoints](Sending-the-Request#api-reference)

# Framework
- [Return Types](Return-Types)
    - [Working with Collections](Return-Types#working-with-a-collection)
- [Rate Limiting](Rate-Limiting)
- [Caching](Caching)

# Collections
@foreach ($class['collections'] as $col)
- [{{ $col->short }}]({{ $col->dashed }})
@endforeach

Licensed under the MIT License
