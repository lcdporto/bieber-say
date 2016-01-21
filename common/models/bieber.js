module.exports = function(Bieber) {
    var exec = require('child_process').exec;

    Bieber.say = function(text, cb) {
        var cmd = 'say "' + text + '"';

        exec(cmd, function(error, stdout, stderr) {
            stdout = (stdout || 'ok');

            var template = {};
            template.cmd = cmd;
            template.result = stdout;
            cb(null, template);
        });

    };

    Bieber.remoteMethod('say', {
        http: {path: '/', verb: 'get'},
        accepts: {arg: 'text', type: 'string'},
        returns: {arg: 'data', type: 'object'}
    });
};
