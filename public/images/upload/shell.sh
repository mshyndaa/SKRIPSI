#!/bin/bash

file="mystream.m3u8"

if [ -f "$file" ] ; then
    rm "$file"
fi
VIDSOURCE="rtsp://admin:qwaszx12@192.168.108.190:554/cam/realmonitor?channel:=1&subtype=0"
AUDIO_OPTS="-c:a aac -b:a 160000 -ac 2"
VIDEO_OPTS="-s 854x480 -c:v libx264 -b:v 50000"
OUTPUT_HLS="-hls_time 10 -hls_list_size 2 -start_number 1"
ffmpeg -i "$VIDSOURCE" -y $AUDIO_OPTS $VIDEO_OPTS $OUTPUT_HLS mystream.m3u8
#ffmpeg -i rtsp://admin:qwaszx12@192.168.108.190:554 -c copy -flags +global_header -f segment -segment_time 60 -segment_format_options movflags=+faststart -reset_timestamps 1 test%d.mp4

