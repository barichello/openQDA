# Pipoca (formerly OpenQDA)

Web-based software to do qualitative analysis. So far, the software supports images and videos.

This software was created to help me organize and analyse the data I collected for my Ph.D. research project (http://www.barichello.coffee/about-my-research), but it was the first step towards an open alternative for NVivo.

At this moment, the software lacks some basic features. If you are looking for something ready to use, DO NOT use this software. I just shared as a way to find more people interested in a long term partnership to develop it.

# How it works

The software works based on four concepts: sources, codes, sections and attributes.

Sources: they are the files which actualy contain the data to be organized and analysed. At this moment, it only supports images and videos, but I intend to expand it to text and audios.

Attributes: you can apply attributes to sources as a way to organize, describe or even analyse them. For instance, you may create the attribute DATE and then use it to record the date in which a source was created.

Sections: they are parts (or fragments) of a source. In the case of an image, it is a rectangular section of it. For a text, a section would be a string. For a video or audio, it would be a time interval.

Codes: they are like tags that can be applied to sections (not sources). This is sort of the universal tool for qualitative analysis (NVivo calls them nodes). Tipically, the researcher identifies a part of a source (for instance, a sentence from an interview) and associates that part with a code that refers to a phenomena of interest.

# To-do list

1) Support audio sources;

2) Decide what type of text will be supported and implement it;

3) Decide how to enable add-ons;

# Important notes

1) The software is only tested on Firefox;

2) The upload functionality is not fully developed, so pay attention to what you insert on it;

# Installation

1) Copy the files to a folder in your webserver;

2) Create the database as specified in the file database.txt;

3) Adjust the info in the file connection.php;

4) Run it in your browser!
