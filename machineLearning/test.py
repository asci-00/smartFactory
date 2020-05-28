#기존 학습데이터 불러오기
from tensorflow.keras.models import load_model
model = load_model('embed_model.h5')
import sys
import numpy as np
import matplotlib.pyplot as plt
import time
import os
np.random.seed(3)

from tensorflow.keras.preprocessing.image import ImageDataGenerator
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense
from tensorflow.keras.layers import Flatten
from tensorflow.keras.layers import Conv2D
from tensorflow.keras.layers import MaxPooling2D
from datetime import datetime as dt
from time import sleep
from operator import eq
tmp = open('loaddata.py','r')
prev = tmp.read()
next = prev
tmp.close()
dir = "right"

while True:
	comp = eq(prev,next)
	if comp:
		print("same")
		sleep(1)
	else :
		prev = next
		#트레인셋 불러오기
		train_datagen = ImageDataGenerator(rescale=1./255,
						rotation_range=10,
						width_shift_range=0.2,
						height_shift_range=0.2,
						shear_range=0.7,
						zoom_range=[0.9,2.2],
						horizontal_flip=True,
						vertical_flip=True,
						fill_mode='nearest')

		train_generator = train_datagen.flow_from_directory('embeddedlab/train', target_size=(24,24,),batch_size=3,class_mode='categorical')


		#테스트셋 불러오기
		test_datagen = ImageDataGenerator(rescale=1./255)

		test_generator = test_datagen.flow_from_directory('embeddedlab/test', target_size=(24,24,),batch_size=3,class_mode='categorical')

		#모델 엮기
		model.compile(loss='categorical_crossentropy', optimizer='adam', metrics=['accuracy'])

		#모델 학습시키기
		model.fit_generator(train_generator, steps_per_epoch=15, epochs=1, validation_data=test_generator, validation_steps=5)

		#결과
		print("-- Evaluate --")

		scores = model.evaluate_generator(test_generator, steps=5)

		print("%s: %.2f%%" %(model.metrics_names[1], scores[1]*100))

		#정확도
		print("-- Predict --")

		output = model.predict_generator(test_generator, steps=5)

		np.set_printoptions(formatter={'float' : lambda x : "{0:0.3f}".format(x)})

		print(output)

		#판정

		print(scores[1])
		if scores[1]*100>=50:
		# 레일 우회전 함수
		#
			print("양품입니다!")
			dir = "right"
			sleep(1)
		else :
		# 레일 좌회전 함수
		#
			print("불량입니다!")
			dir = "left"
			sleep(1)
		test_img=plt.imread('embeddedlab/test/cola/data.jpg')
		plt.imshow(test_img);
	tmp =open('loaddata.py','r')
	next=tmp.read()
	tmp.close()
	sertmp = open('howservo.py','w')
	sertmp.write(dir)
	sertmp.close()
	shellcommand = "sshpass -p419419 scp -o StrictHostKeyChecking=no ./howservo.py pi@210.119.104.156:/home/pi/test/howservo.py"
	os.system(shellcommand)
	os.system("clear")

