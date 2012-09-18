# README - Team WYD
Update: Service was not working because conversion website blocked IP of server. I've switched to heroku, so it's working currently.
Will have to think of something for this. Probably some other way to convert audio?

Working!

To try the latest code:

Call 011-30908632
Ask a question after the beep.
Wait 15-20 seconds. It will return answer of the query.

Basic Idea :
A SIRI implementation for Kookoo.Enables users to serach for answers on the web without an active internet connection using kookoo API.

Implementation:
1. Record callers question, convert it to flac using an online convertor and send file to google speech to text.
2. Result is passed to wolfram alpha.
3. Answer is relayed to user through kookoo's text to speech.

Google speech to text is central to our application. Moreover, its utility can be easily extended further -e.g. Specific 
keyword based actions for NEWS, WEATHER that uses the caller circle information to return appropriate information.
Another possibility would be sending response via SMS to reduce call duration which otherwise is pretty lengthy.

Essentially, after speech to text, possibilities from utility point of view are endless.