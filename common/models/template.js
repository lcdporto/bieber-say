module.exports = function(Template) {

    var exec = require('child_process').exec;

    Template.say = function(templateId, cb) {
        Template.findById(templateId, function (err, instance) {
            var template = instance;
            var cmd = 'say "' + Template.resolveText(template) + '"';

            exec(cmd, function(error, stdout, stderr) {
                stdout = (stdout || 'ok');

                template.cmd = cmd;
                template.result = stdout;
                cb(null, template);
            });

        });
    };

    Template.resolveText = function(template) {
        return template.text;
    };

    Template.remoteMethod('say', {
        http: {path: '/say', verb: 'get'},
        accepts: {arg: 'id', type: 'number'},
        returns: {arg: 'data', type: 'object'}
    });
};
