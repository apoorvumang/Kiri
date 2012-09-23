# README - Team WYD - Kiri
To try the latest code:

Call 011-30908632
Ask a question after the beep.

Wait 5-10 seconds. It will return answer of the query.


Description: A Siri implementation for Kookoo. Enables users to search for answers on the web without an active internet connection using Kookoo API.

Implementation: 

1. Record callers question, convert it to flac send file to google speech to text.

2. Search query text for keywords(movies, cricket, weather) and call appropriate API.

3. If no keyword found, look for answer on wolfram alpha.

4. Answer is relayed to user through kookoo's text to speech.


Technologies used:

1. Google speech to text for converting recording to plain text

2. Weather Underground API for weather

3. RottenTomatoes for movie reviews

4. Custom script for live cricket scores

5. Wolfram Alpha API for general questions


Scope:

1. Inclusion of more APIs such as spelling, news, other sports.

2. User specific functionality, since we can identify user based on caller ID



