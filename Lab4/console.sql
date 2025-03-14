CREATE TABLE LabTech(
CREATE TABLE LabTech(
    LabTech_id char(4) NOT NULL PRIMARY KEY ,
    firstname char(50) NOT NULL,
    lastname char(50) NOT NULL
);

CREATE TABLE Analysis(
    Analysis varchar(4) NOT NULL PRIMARY KEY ,
    Full_AnalysisName varchar(15) NOT NULL,
    Unit varchar(10) NOT NULL,
    Full_UnitName varchar(10) NOT NULL
);

CREATE TABLE Sample(
    Sample_id varchar(6) NOT NULL ,
    date date NOT NULL ,
    Sample_notes varchar(100) NULL,
    PRIMARY KEY (Sample_id)
);

CREATE TABLE  Result(
    Sample_id varchar(6) NOT NULL,
    Analysis varchar(4) NOT NULL ,
    LabTech_id char(4) NOT NULL ,
    Results float(4) NOT NULL,
    PRIMARY KEY (Sample_id),
    FOREIGN KEY (Sample_id) REFERENCES Sample(sample_id),
    FOREIGN KEY (LabTech_id) REFERENCES LabTech(labtech_id),
    FOREIGN KEY (Analysis) REFERENCES  Analysis(analysis)
);

INSERT INTO LabTech(LabTech_id, firstname, lastname)
VALUES
    ('EID1', 'Jennifer','Johnson'),
    ('EID2','Joey','Smallwood'),
    ('EID3','Lisa','Millhouse');

INSERT INTO Analysis(Analysis, Full_AnalysisName, Unit, Full_UnitName)
VALUES
    ('Cl','Free Chlorine','mg/L','mg/L');

INSERT INTO Sample(sample_id, date, sample_notes)
VALUES
    ('A0001','2016-01-01','');

INSERT INTO Result(sample_id, analysis, labtech_id, results)
VALUE
('A0001','Cl','EID3','1.1');

