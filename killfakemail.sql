delete from mxaliases where valid_thru<current_timestamp and permanent<>'Y';
